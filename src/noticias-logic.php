<?php
// src/noticias-logic.php

function obtenerNoticias($conn) {
    $sql = "SELECT * FROM noticias ORDER BY fecha_creacion DESC";
    return mysqli_query($conn, $sql);
}

function obtenerNoticiasPublicas($conn) {
    $sql = "SELECT * FROM noticias WHERE estado = 'Publicada' ORDER BY fecha_creacion DESC";
    return mysqli_query($conn, $sql);
}

function obtenerNoticiaPorId($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM noticias WHERE id = ? AND estado = 'Publicada'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertarNoticia($conn, $titulo, $contenido, $autor_id) {
    $errores = [];
    $titulo = trim($titulo);
    $contenido = trim($contenido);

    if (strlen($titulo) < 10 || strlen($titulo) > 100) {
        $errores[] = "El título debe tener entre 10 y 100 caracteres.";
    }
    if (strlen($contenido) < 50) {
        $errores[] = "La descripción debe tener al menos 50 caracteres.";
    }

    if (empty($errores)) {
        // La tabla ahora permite NULL en imagen y fecha_publicacion gracias al ALTER TABLE
        $stmt = $conn->prepare("INSERT INTO noticias (titulo, descripcion, estado, autor_id) VALUES (?, ?, 'Borrador', ?)");
        $stmt->bind_param("ssi", $titulo, $contenido, $autor_id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return ["Error en la base de datos: " . $stmt->error];
        }
    }
    return $errores;
}

/**
 * Trae las noticias que necesitan revisión (para el Validador)
 */
function obtenerNoticiasPendientes($conn) {
    // Hacemos un JOIN para saber quién escribió la noticia
    $sql = "SELECT n.*, u.nombre as nombre_autor 
            FROM noticias n 
            JOIN usuarios u ON n.autor_id = u.id 
            WHERE n.estado = 'Borrador' OR n.estado = 'Lista para Validación'
            ORDER BY n.fecha_creacion DESC";
    return mysqli_query($conn, $sql);
}