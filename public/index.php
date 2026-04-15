<?php
session_start();
require_once '../config/db.php';
require_once '../src/helpers.php';
require_once '../src/noticias-logic.php';
require_once '../src/auth-logic.php';

$page = $_GET['page'] ?? 'home';
$errores = [];

// PROTECCIÓN: Solo editores logueados pueden entrar a redactar
if ($page === 'nueva-noticia' && !isset($_SESSION['usuario_id'])) {
    header("Location: ?page=login&error=auth");
    exit;
}

// Redirigir al home si alguien logueado intenta ir a login o registro
if (isset($_SESSION['usuario_id']) && ($page === 'login' || $page === 'registro')) {
    header("Location: ?page=home");
    exit;
}

// --- PROCESAMIENTO DE FORMULARIOS (Antes del switch) ---

if ($page === 'guardar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tomamos el ID de quien está logueado
    $autor_id = $_SESSION['usuario_id'];

    $resultado = insertarNoticia($conn, $_POST['titulo'], $_POST['contenido'], $autor_id);

    if ($resultado === true) {
        header("Location: ?page=noticias&success=1");
        exit;
    } else {
        $errores = $resultado;
        $page = 'nueva-noticia';
    }
}

if ($page === 'procesar-registro' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = registrarUsuario($conn, $_POST['nombre'], $_POST['email'], $_POST['password']);
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

// --- CARGA DE VISTAS ---
ob_start();
switch ($page) {
    case 'noticias':
        $noticias = obtenerNoticiasPublicas($conn);
        include '../views/noticias/lista.php';
        break;

    case 'noticia':
        $id = $_GET['id'] ?? 0;
        $noticia = obtenerNoticiaPorId($conn, $id);
        if (!$noticia) {
            header("Location: ?page=noticias");
            exit;
        }
        include '../views/noticias/detalle.php';
        break;

    case 'validar-noticias':
        // PROTECCIÓN: Solo el rol 2 (Validador) puede entrar acá
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] != 2) {
            header("Location: ?page=home");
            exit;
        }
        $noticias_pendientes = obtenerNoticiasPendientes($conn);
        include '../views/validador/lista.php';
        break;

    case 'nueva-noticia':
        include '../views/noticias/formulario.php';
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
