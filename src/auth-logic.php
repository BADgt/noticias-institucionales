<?php
// src/auth-logic.php

function registrarUsuario($conn, $nombre, $email, $password) {
    $errores = [];
    $nombre = trim($nombre);
    $email = trim($email);

    if (empty($nombre) || empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    if (strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $errores[] = "Este email ya está registrado.";
    }

    if (empty($errores)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $passwordHash);
        
        if ($stmt->execute()) {
            $usuario_id = $conn->insert_id;
            $stmt_rol = $conn->prepare("INSERT INTO usuario_rol (usuario_id, rol_id) VALUES (?, 1)");
            $stmt_rol->bind_param("ii", $usuario_id);
            $stmt_rol->execute();
            return true;
        }
    }
    return $errores;
}

function iniciarSesion($conn, $email, $password) {
    // IMPORTANTE: El JOIN trae el rol de la tabla intermedia
    $stmt = $conn->prepare("SELECT u.id, u.nombre, u.password, ur.rol_id 
                            FROM usuarios u 
                            LEFT JOIN usuario_rol ur ON u.id = ur.usuario_id 
                            WHERE u.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        // Si no tiene rol, le asignamos 0 para evitar el error "Undefined index"
        $_SESSION['usuario_rol'] = $user['rol_id'] ?? 0; 
        return true;
    }
    return ["Email o contraseña incorrectos."];
}