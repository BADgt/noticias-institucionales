<?php
// Función para limpiar el HTML y evitar inyecciones de script
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}