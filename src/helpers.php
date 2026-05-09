<?php
// src/helpers.php

/**
 * Función para escapar HTML de forma segura (abreviatura de htmlspecialchars)
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Función para debuguear rápido 
 */
function dd($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die();
}
/**
 * Valida que un nombre solo contenga letras (incluye acentos y ñ) y espacios.
 */
function esNombreValido($cadena) {
    // La expresion regular verifica desde el inicio (^) hasta el final ($)
    // \p{L} acepta cualquier letra de cualquier idioma (incluye ñ y acentos)
    // \s acepta espacios.
    return preg_match('/^[\p{L}\s\']+$/u', $cadena);
}

/**
 * Valida que un texto tenga letras, numeros, puntuacion basica y caracteres coreanos.
 * Tambien asegura que el texto contenga al menos una letra (no puede ser solo numeros).
 */
function esTextoNoticiaValido($cadena) {
    // 1. Verificamos que tenga al menos una letra (latina o coreana)
    if (!preg_match('/[\p{L}]/u', $cadena)) {
        return false;
    }
    
    // 2. Verificamos que solo contenga caracteres permitidos:
    // \p{L} -> Letras (cualquier idioma, incluye Hangul coreano)
    // \p{N} -> Numeros
    // \s -> Espacios y saltos de linea
    // \p{P} -> Signos de puntuacion (?, !, ., ,, (, ), -, etc.)
    return preg_match('/^[\p{L}\p{N}\s\p{P}]+$/u', $cadena);
}

/**
 * Valida el formato estandar de un correo electronico.
 */
function esEmailValido($email) {
    // filter_var es una funcion nativa de PHP muy segura para validar emails
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}