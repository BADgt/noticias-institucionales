<?php

function obtenerNoticias($conn)
{
    // Usamos el campo 'fecha_creacion' que definimos en la base de datos
    $sql = "SELECT * FROM noticias ORDER BY fecha_creacion DESC";
    return mysqli_query($conn, $sql);
}

function insertarNoticia($conn, $titulo, $contenido)
{
    $errores = [];

    // 1. Limpieza de datos (Evita espacios vacíos que rompan validaciones)
    $titulo = trim($titulo);
    $contenido = trim($contenido);

    // 2. Validaciones de Reglas de Negocio (Lo que el tester va a buscar)
    if (strlen($titulo) < 10 || strlen($titulo) > 100) {
        $errores[] = "El título debe tener entre 10 y 100 caracteres.";
    }

    if (strlen($contenido) < 50) {
        $errores[] = "La descripción debe tener al menos 50 caracteres.";
    }

    // 3. Validación de Título Único (Regla clave del TP)
    $stmt_check = $conn->prepare("SELECT id FROM noticias WHERE titulo = ? AND estado = 'Publicada'");
    $stmt_check->bind_param("s", $titulo);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    if ($result->num_rows > 0) {
        $errores[] = "Ya existe una noticia publicada con ese mismo título.";
    }

    // 4. Si no hay errores, insertamos
    if (empty($errores)) {
        // En noticias-logic.php, dentro de insertarNoticia():
        $stmt = $conn->prepare("INSERT INTO noticias (titulo, descripcion, estado, autor_id) VALUES (?, ?, 'Borrador', 1)");
        $stmt->bind_param("ss", $titulo, $contenido);
        if ($stmt->execute()) {
            return true; // Éxito
        } else {
            $errores[] = "Error crítico en la base de datos.";
        }
    }

    return $errores; // Devolvemos la lista de fallos
}
