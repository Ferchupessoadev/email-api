<?php

namespace lib;

class Route
{
    public static $routes = [];

    public static function get(string $uri, callable|array $callback): void
    {
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] = $callback;
    }

    public static function post(string $uri, callable|array $callback): void
    {
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] = $callback;
    }

    static public function Response(array|object|string $response): void
    {
        if (is_array($response) || is_object($response)) {
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo $response;
        }
    }

    public static function start(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = trim($uri, '/');
        $uri = explode('?', $uri)[0];

        foreach (self::$routes[$method] as $route => $callback) {
            if (strpos($uri, '{')) {
                $pattern = '#^' . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $uri) . '$#';
                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches);
                    if (is_callable($callback)) {
                        $response = $callback(...$matches);
                    } else if (is_array($callback) || is_object($callback)) {
                        $controller = new $callback[0]();
                        $response = $controller->{$callback[1]}(...$matches);
                    }
                    self::Response($response);
                    return;
                }
            }

            if ($uri == $route) {
                if (is_callable($callback)) {
                    $response = $callback();
                } else if (is_array($callback) || is_object($callback)) {
                    $controller = new $callback[0]();
                    $response = $controller->{$callback[1]}();
                }
                self::Response($response);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
