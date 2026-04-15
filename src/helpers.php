<?php
// src/helpers.php

// Función para mostrar texto seguro en el HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}