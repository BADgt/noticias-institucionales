<?php
session_start();
require_once '../config/db.php';
require_once '../src/helpers.php';
require_once '../src/noticias-logic.php';
require_once '../src/auth-logic.php';

$page = $_GET['page'] ?? 'home';
$errores = [];

// PROTECCIÓN: Páginas privadas
$paginas_privadas = ['nueva-noticia', 'mis-borradores', 'perfil', 'editar-noticia', 'validar-noticias', 'revisar-noticia'];
if (in_array($page, $paginas_privadas) && !isset($_SESSION['usuario_id'])) {
    header("Location: ?page=login");
    exit;
}

// --- PROCESAMIENTO DE NUEVAS NOTICIAS ---
if ($page === 'guardar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $resumen = trim($_POST['resumen'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $errores_noticia = [];

    // 1. Validamos la longitud minima (Ajustado para caracteres coreanos)
    if (mb_strlen($titulo, 'UTF-8') < 2) {
        $errores_noticia[] = "El titulo es muy corto. Debe tener al menos 2 caracteres.";
    }
    if (mb_strlen($resumen, 'UTF-8') < 5) {
        $errores_noticia[] = "El resumen es muy corto. Debe tener al menos 5 caracteres.";
    }
    if (mb_strlen($contenido, 'UTF-8') < 10) {
        $errores_noticia[] = "El contenido de la noticia es muy corto. Debe tener al menos 10 caracteres.";
    }

    // 2. Validamos el formato de los textos (caracteres permitidos)
    if (!esTextoNoticiaValido($titulo)) {
        $errores_noticia[] = "El titulo contiene simbolos no permitidos o no contiene letras.";
    }
    if (!esTextoNoticiaValido($resumen)) {
        $errores_noticia[] = "El resumen contiene simbolos no permitidos o no contiene letras.";
    }
    if (!esTextoNoticiaValido($contenido)) {
        $errores_noticia[] = "El contenido contiene simbolos no permitidos o no contiene letras.";
    }

    // Si hay errores, guardamos los datos en sesion y redirigimos de vuelta
    if (!empty($errores_noticia)) {
        $_SESSION['errores_noticia'] = $errores_noticia;
        $_SESSION['datos_temporales'] = $_POST;
        header("Location: ?page=nueva-noticia");
        exit;
    }

    // Si todo esta bien, guardamos en la base de datos
    $estado = ($_POST['accion'] === 'revisar') ? 'Lista para Validación' : 'Borrador';
    insertarNoticiaCompleta($conn, $titulo, $resumen, $contenido, $_FILES['imagen'], $estado, $_SESSION['usuario_id']);
    header("Location: ?page=home&success=1");
    exit;
}

// --- PROCESAMIENTO DE ACTUALIZACION DE NOTICIAS ---
if ($page === 'actualizar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $resumen = trim($_POST['resumen'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $id_noticia = $_POST['id'];
    $errores_noticia = [];

    // 1. Validamos la longitud minima (Ajustado para caracteres coreanos)
    if (mb_strlen($titulo, 'UTF-8') < 2) {
        $errores_noticia[] = "El titulo es muy corto. Debe tener al menos 2 caracteres.";
    }
    if (mb_strlen($resumen, 'UTF-8') < 5) {
        $errores_noticia[] = "El resumen es muy corto. Debe tener al menos 5 caracteres.";
    }
    if (mb_strlen($contenido, 'UTF-8') < 10) {
        $errores_noticia[] = "El contenido de la noticia es muy corto. Debe tener al menos 10 caracteres.";
    }

    // 2. Validamos el formato de los textos
    if (!esTextoNoticiaValido($titulo)) {
        $errores_noticia[] = "El titulo contiene simbolos no permitidos o no contiene letras.";
    }
    if (!esTextoNoticiaValido($resumen)) {
        $errores_noticia[] = "El resumen contiene simbolos no permitidos o no contiene letras.";
    }
    if (!esTextoNoticiaValido($contenido)) {
        $errores_noticia[] = "El contenido contiene simbolos no permitidos o no contiene letras.";
    }

    // Si hay errores, guardamos en sesion y redirigimos al editor
    if (!empty($errores_noticia)) {
        $_SESSION['errores_noticia'] = $errores_noticia;
        header("Location: ?page=editar-noticia&id=" . $id_noticia);
        exit;
    }

    // Si todo esta bien, procedemos a actualizar
    $nuevo_estado = ($_POST['accion'] === 'revisar') ? 'Lista para Validación' : 'Borrador';
    $borrar_imagen = $_POST['borrar_imagen_actual'] ?? '0';

    $resultado = actualizarNoticiaCompleta(
        $conn, $id_noticia, $titulo, $resumen, $contenido, $_FILES['imagen'] ?? null, $nuevo_estado, $borrar_imagen 
    );

    if ($resultado) {
        header("Location: ?page=home&success=update");
        exit;
    }
}

if ($page === 'procesar-revision' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    cambiarEstadoNoticia($conn, $_POST['noticia_id'], $_POST['estado'], $_SESSION['usuario_id']);
    header("Location: ?page=validar-noticias&success=1");
    exit;
}

// INICIO PROCESAMIENTO PARA BAJAR NOTICIA
if ($page === 'bajar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    /* * Reutilizamos la funcion existente cambiarEstadoNoticia.
     * Forzamos el estado a 'Anulada' para que desaparezca de la vista publica 
     * pero siga existiendo en el historial del usuario.
     */
    cambiarEstadoNoticia($conn, $_POST['noticia_id'], 'Anulada', $_SESSION['usuario_id']);

    // Redirigimos al usuario a su perfil para que vea reflejado el cambio en su historial
    header("Location: ?page=perfil&success=baja");
    exit;
}
// FIN PROCESAMIENTO PARA BAJAR NOTICIA

if ($page === 'procesar-registro' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = registrarUsuario($conn, $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['password'], $_POST['roles'] ?? []);
    if ($resultado === true) {
        header("Location: ?page=login&registrado=1");
        exit;
    }
    $errores = $resultado;
    $page = 'registro';
}

if ($page === 'procesar-login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = iniciarSesion($conn, $_POST['email'], $_POST['password']);
    if ($resultado === true) {
        header("Location: ?page=home");
        exit;
    }
    $errores = $resultado;
    $page = 'login';
}

if ($page === 'logout') {
    session_destroy();
    header("Location: ?page=home");
    exit;
}

// --- VISTAS ---
ob_start();
switch ($page) {
    case 'noticias':
        $noticias = obtenerNoticiasPublicas($conn);
        include '../views/noticias/lista.php';
        break;
    case 'noticia':
        $noticia = obtenerNoticiaPorId($conn, $_GET['id'] ?? 0);
        include '../views/noticias/detalle.php';
        break;
    case 'mis-borradores':
        $borradores = obtenerMisBorradores($conn, $_SESSION['usuario_id']);
        include '../views/noticias/mis-borradores.php';
        break;
    case 'editar-noticia':
        $noticia = obtenerNoticiaParaEditar($conn, $_GET['id'] ?? 0, $_SESSION['usuario_id']);
        include '../views/noticias/formulario.php';
        break;
    case 'validar-noticias':
        $noticias_pendientes = obtenerNoticiasPendientes($conn);
        include '../views/validador/lista.php';
        break;
    case 'revisar-noticia':
        $noticia = obtenerNoticiaParaEditar($conn, $_GET['id'] ?? 0);
        include '../views/validador/revision.php';
        break;
    case 'nueva-noticia':
        include '../views/noticias/formulario.php';
        break;
    case 'eliminar-noticia':
        include '../views/eliminar-noticia.php';
        break;
    case 'perfil':
        include '../views/auth/perfil.php';
        break;
    case 'login':
        include '../views/auth/login.php';
        break;
    case 'registro':
        include '../views/auth/registro.php';
        break;
    default:
        include '../views/home.php';
        break;
}
$content = ob_get_clean();
include '../views/header.php';
echo $content;
include '../views/footer.php';
