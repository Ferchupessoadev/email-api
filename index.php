<?php

require 'vendor/autoload.php';

use lib\Route;

ini_set('display_errors', 1);

Route::get('/', function () {
    echo 'Hello World';
});

Route::get('/about', function () {
    echo 'About';
});

Route::start();
