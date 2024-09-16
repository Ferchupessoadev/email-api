<?php
// config.php
// app config file

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Cors
header('Access-Control-Allow-Origin: https://ferchudev.com');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
