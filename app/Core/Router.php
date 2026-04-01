<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($uri, PHP_URL_PATH);

        if (array_key_exists($path, $this->routes[$method])) {
            $handler = $this->routes[$method][$path];
            $this->callAction($handler);
        } else {
            // Check for 404
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    protected function callAction($handler)
    {
        list($controller, $action) = explode('@', $handler);
        $controllerClass = "App\\Controllers\\$controller";

        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                echo "Action $action not found in controller $controller";
            }
        } else {
            echo "Controller $controller not found";
        }
    }
}
