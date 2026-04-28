<?php
if (isset($_GET['id']) && isset($_SESSION['usuario_id'])) {
    $id = $_GET['id'];
    $autor_id = $_SESSION['usuario_id'];

    // Borramos solo si es borrador y el autor es el que está logueado
    $stmt = $conn->prepare("DELETE FROM noticias WHERE id = ? AND autor_id = ? AND estado = 'Borrador'");
    $stmt->bind_param("ii", $id, $autor_id);

    if ($stmt->execute()) {
        header("Location: ?page=mis-borradores&mensaje=eliminado");
    } else {
        echo "Error al eliminar.";
    }
} else {
    header("Location: ?page=mis-borradores");
}
exit;