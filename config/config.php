<?php
// config.php
// app config file

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Quitar el encabezado X-Powered-By
header_remove('X-Powered-By');

// Cors
$allowed_origins = [
    'https://ferchudev.com',
    'https://uniontkd.com.ar'
];

// Obtener el origen de la solicitud
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Verificar si el origen está en la lista permitida
if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
}
