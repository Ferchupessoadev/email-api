<?php

require 'vendor/autoload.php';

use App\Controllers\Home;
use App\Controllers\SendEmailController;
use Dotenv\Dotenv;
use lib\Route;

Dotenv::createImmutable(__DIR__)->load();

Route::get('/', [Home::class, 'index']);

Route::post('/', [SendEmailController::class, 'index']);

Route::start();
