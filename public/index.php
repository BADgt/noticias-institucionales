<?php
// public/index.php
require_once '../config/db.php';
require_once '../src/noticias-logic.php'; // Lo cargamos arriba para que esté disponible siempre

$page = $_GET['page'] ?? 'home';
$errores = []; // Para guardar errores y pasarlos a la vista

// Lógica de procesamiento antes de renderizar
if ($page === 'guardar-noticia' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';

    $resultado = insertarNoticia($conn, $titulo, $contenido);

    if ($resultado === true) {
        header("Location: ?page=noticias&success=1");
        exit;
    } else {
        $errores = $resultado; // Guardamos los errores para el formulario
        $page = 'nueva-noticia'; // Forzamos la vista del formulario
    }
}

ob_start(); 
switch ($page) {
    case 'noticias':
        $noticias = obtenerNoticias($conn);
        include '../views/noticias/lista.php';
        break;
    case 'nueva-noticia':
        // Aquí $errores estará disponible si venimos de un fallo al guardar
        include '../views/noticias/formulario.php';
        break;
    default:
        include '../views/home.php';
        break;
}
$content = ob_get_clean();

include '../views/header.php';
echo $content;
include '../views/footer.php';