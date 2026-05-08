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