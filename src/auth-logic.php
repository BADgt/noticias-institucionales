<?php
// src/auth-logic.php

function registrarUsuario($conn, $nombre, $apellido, $email, $password, $roles_seleccionados) {
    $errores = [];
    $nombre = trim($nombre); $apellido = trim($apellido); $email = trim($email);

    if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($roles_seleccionados)) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (empty($errores)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $passwordHash);
        
        if ($stmt->execute()) {
            $usuario_id = $conn->insert_id;
            foreach ($roles_seleccionados as $rol_id) {
                $stmt_rol = $conn->prepare("INSERT INTO usuario_rol (usuario_id, rol_id) VALUES (?, ?)");
                $stmt_rol->bind_param("ii", $usuario_id, $rol_id);
                $stmt_rol->execute();
            }
            return true;
        } else { $errores[] = "Error: El email ya está en uso."; }
    }
    return $errores;
}

function iniciarSesion($conn, $email, $password) {
    $stmt = $conn->prepare("SELECT u.*, GROUP_CONCAT(ur.rol_id) as roles_ids 
                            FROM usuarios u 
                            LEFT JOIN usuario_rol ur ON u.id = ur.usuario_id 
                            WHERE u.email = ? 
                            GROUP BY u.id");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nombre'] = $user['nombre'];
        $_SESSION['usuario_apellido'] = $user['apellido'];
        $_SESSION['usuario_email'] = $user['email']; 
        
        $roles_raw = $user['roles_ids'] ?? '';
        $_SESSION['usuario_roles'] = !empty($roles_raw) ? explode(',', $roles_raw) : [];
        
        return true;
    }
    return ["Credenciales incorrectas."];
}