<?php
namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, callable|array $action): void
    {
        $this->addRoute('POST', $path, $action);
    }

    private function addRoute(string $method, string $path, $action): void
    {
        $this->routes[$method][$path] = $action;
    }

    public function route(string $uri, string $method): void
    {
        $uri = rtrim($uri, '/') ?: '/';

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "Página no encontrada: $uri";
            return;
        }

        $action = $this->routes[$method][$uri];

        if (is_array($action)) {
            [$class, $method] = $action;
            (new $class())->$method();
        } else {
            $action();
        }
    }
}
