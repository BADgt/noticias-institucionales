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

// --- PROCESAMIENTO ---
if ($page === 'guardar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = ($_POST['accion'] === 'revisar') ? 'Lista para Validación' : 'Borrador';
    insertarNoticiaCompleta($conn, $_POST['titulo'], $_POST['resumen'], $_POST['contenido'], $_FILES['imagen'], $estado, $_SESSION['usuario_id']);
    header("Location: ?page=home&success=1");
    exit;
}

// --- PROCESAMIENTO DE FORMULARIOS ---
if ($page === 'actualizar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_estado = ($_POST['accion'] === 'revisar') ? 'Lista para Validación' : 'Borrador';
    
    $borrar_imagen = $_POST['borrar_imagen_actual'] ?? '0';

    $resultado = actualizarNoticiaCompleta(
        $conn,
        $_POST['id'],
        $_POST['titulo'],
        $_POST['resumen'],
        $_POST['contenido'],
        $_FILES['imagen'] ?? null,
        $nuevo_estado,
        $borrar_imagen 
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
