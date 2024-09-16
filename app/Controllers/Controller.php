<?php

namespace App\Controllers;

abstract class Controller
{
    /**
     * Render a view
     * @param array $data
     * @param string $route
     * @return string
     */
    public function view(string $route, array $data = []): string
    {
        $route = str_replace('.', '/', $route);
        if (file_exists('views/' . $route . '.php')) {
            // sanitize data
            if (count($data) > 0) {
                foreach ($data as $key => $value) {
                    $data[$key] = htmlspecialchars($value);
                }
            }
            // extract data to be used in view
            extract($data);
            ob_start();
            include 'views/' . $route . '.php';
            return ob_get_clean();
        } else {
            throw new \Exception('View not found');
        }
    }
}
