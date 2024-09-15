<?php

use lib\Route;

Route::get('/api', function () {
    return 'Hello World';
});

Route::start();
