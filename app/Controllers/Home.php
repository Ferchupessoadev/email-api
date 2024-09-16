<?php

namespace App\Controllers;

use App\Controllers\Controller;

class Home extends Controller
{
    public function index(): array
    {
        $data = [
            'nameApi' => $_ENV['NAME_API'],
            'date' => date('Y-m-d H:i:s'),
            'version' => $_ENV['VERSION'],
        ];

        return $data;
    }
}
