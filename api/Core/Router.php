<?php

namespace Api\Core;

class Router {
    private array $routes = [];
    private string $base = '';
    private string $assetPath;

    public function __construct() {
        $this->base = dirname($_SERVER['SCRIPT_NAME']);
        // $this->assetPath = realpath(__DIR__ . '/../../public/assets') . '/';
    }

    public function add(string $route, mixed $path): void {
        $this->routes[$route] = is_callable($path) 
            ? ['type' => 'callback', 'handler' => $path]
            : ['type' => 'view', 'path' => $path];
    }

    public function getAssetPath(string $url): string {
        return $this->assetPath . $url;
    }

    public function run(): void {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim(str_replace($this->base, '', $requestUri), '/');
        
        ob_start();

        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];
            
            match($route['type']) {
                'callback' => call_user_func($route['handler']),
                'view' => require_once __DIR__ . '/../../public/pages/' . $route['path']
            };
        } else {
            require_once __DIR__ . '/../../public/pages/NotFound.php';
        }

        $Body = ob_get_clean();
        $Base = $this->base;
        
        require_once __DIR__ . '/../../public/App.php';
    }
}
