<?php
// config.php
// app config file

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Quitar el encabezado X-Powered-By
header_remove('X-Powered-By');

// Cors
header('Access-Control-Allow-Origin: https://ferchudev.com, https://uniontkd.com.ar');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}
