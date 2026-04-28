<?php
// src/noticias-logic.php

function obtenerNoticiasPublicas($conn) {
    $sql = "SELECT n.*, u.nombre, u.apellido 
            FROM noticias n 
            JOIN usuarios u ON n.autor_id = u.id 
            WHERE n.estado = 'Publicada' 
            ORDER BY n.fecha_publicacion DESC";
    return mysqli_query($conn, $sql);
}

// ... (Acá abajo deberías tener tus otras funciones que ya tenías, como insertarNoticiaCompleta o obtenerNoticiaParaEditar. No las borres) ...
function obtenerNoticiaPorId($conn, $id) {
    // Le quitamos el AND n.estado = 'Publicada' para que el autor pueda ver sus borradores o anuladas
    $stmt = $conn->prepare("SELECT n.*, u.nombre, u.apellido 
                            FROM noticias n 
                            JOIN usuarios u ON n.autor_id = u.id 
                            WHERE n.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertarNoticiaCompleta($conn, $titulo, $resumen, $contenido, $imagen_file, $estado, $autor_id) {
    $nombre_imagen = null;
    if (isset($imagen_file) && $imagen_file['error'] === 0) {
        $ext = pathinfo($imagen_file['name'], PATHINFO_EXTENSION);
        $nombre_imagen = time() . "_" . uniqid() . "." . $ext;
        if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }
        move_uploaded_file($imagen_file['tmp_name'], "uploads/" . $nombre_imagen);
    }
    $stmt = $conn->prepare("INSERT INTO noticias (titulo, resumen, descripcion, imagen, estado, autor_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $titulo, $resumen, $contenido, $nombre_imagen, $estado, $autor_id);
    return $stmt->execute();
}

function obtenerMisBorradores($conn, $autor_id) {
    $stmt = $conn->prepare("SELECT * FROM noticias WHERE autor_id = ? AND estado = 'Borrador' ORDER BY fecha_creacion DESC");
    $stmt->bind_param("i", $autor_id);
    $stmt->execute();
    return $stmt->get_result();
}

function obtenerNoticiaParaEditar($conn, $id, $autor_id = 0) {
    if ($autor_id > 0) {
        $stmt = $conn->prepare("SELECT n.*, u.nombre, u.apellido FROM noticias n JOIN usuarios u ON n.autor_id = u.id WHERE n.id = ? AND n.autor_id = ?");
        $stmt->bind_param("ii", $id, $autor_id);
    } else {
        $stmt = $conn->prepare("SELECT n.*, u.nombre, u.apellido FROM noticias n JOIN usuarios u ON n.autor_id = u.id WHERE n.id = ?");
        $stmt->bind_param("i", $id);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function obtenerNoticiasPendientes($conn) {
    $sql = "SELECT n.*, u.nombre, u.apellido FROM noticias n JOIN usuarios u ON n.autor_id = u.id WHERE n.estado = 'Lista para Validación' ORDER BY n.fecha_creacion DESC";
    return mysqli_query($conn, $sql);
}

function cambiarEstadoNoticia($conn, $id, $nuevo_estado, $usuario_id) {
    $stmt = $conn->prepare("UPDATE noticias SET estado = ?, fecha_publicacion = IF(? = 'Publicada', NOW(), fecha_publicacion) WHERE id = ?");
    $stmt->bind_param("ssi", $nuevo_estado, $nuevo_estado, $id);
    return $stmt->execute();
}

function obtenerHistorialUsuario($conn, $usuario_id) {
    $stmt = $conn->prepare("SELECT * FROM noticias WHERE autor_id = ? ORDER BY fecha_creacion DESC LIMIT 5");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Actualiza una noticia existente (mantiene la imagen si no se sube una nueva)
 */
function actualizarNoticiaCompleta($conn, $id, $titulo, $resumen, $contenido, $imagen_file, $estado, $borrar_imagen = '0') {
    
    // 1. ¿Subió una foto nueva? (Prioridad alta)
    if (isset($imagen_file) && $imagen_file['error'] === 0) {
        $ext = pathinfo($imagen_file['name'], PATHINFO_EXTENSION);
        $nombre_imagen = time() . "_" . uniqid() . "." . $ext;
        move_uploaded_file($imagen_file['tmp_name'], "uploads/" . $nombre_imagen);
        
        $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, resumen = ?, descripcion = ?, imagen = ?, estado = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $titulo, $resumen, $contenido, $nombre_imagen, $estado, $id);
    } 
    // 2. ¿NO subió nada pero apretó el TACHITO (el mensajero mandó '1')?
    elseif ($borrar_imagen === '1') {
        $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, resumen = ?, descripcion = ?, imagen = NULL, estado = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $titulo, $resumen, $contenido, $estado, $id);
    } 
    // 3. ¿NO subió nada y NO tocó el tachito? (Mantenemos la foto vieja)
    else {
        $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, resumen = ?, descripcion = ?, estado = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $titulo, $resumen, $contenido, $estado, $id);
    }
    
    return $stmt->execute();
}