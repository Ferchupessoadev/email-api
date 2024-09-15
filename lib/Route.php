<?php

namespace lib;

class Route
{
    public static $routes = [];

    public static function get($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] = $callback;
    }

    public static function start()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = trim($uri, '/');
        $uri = explode('?', $uri)[0];

        foreach (self::$routes[$method] as $route => $callback) {
            $route = trim($route, '/');
            if ($route == $uri) {
                $callback();
                return;
            }
        }
    }
}
