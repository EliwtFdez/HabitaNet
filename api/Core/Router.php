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
        // Obtener la ruta solicitada del parámetro 'url' establecido por .htaccess
        $uri = $_GET['url'] ?? ''; 
        $uri = trim($uri, '/'); // Limpiar slashes al inicio/final
    
        // Línea de depuración
        error_log("Router URI procesada: '" . $uri . "'");
    
        ob_start();
    
        // Buscar coincidencia exacta primero
        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];
            $this->handleRoute($route);
        } else {
            // Buscar coincidencia con parámetros
            foreach ($this->routes as $pattern => $route) {
                // Convertir el patrón de ruta en una expresión regular
                $pattern = str_replace('/', '\/', $pattern);
                $pattern = preg_replace('/\(\\\d\+\)/', '(\d+)', $pattern);
                $pattern = '/^' . $pattern . '$/';
                
                if (preg_match($pattern, $uri, $matches)) {
                    // Eliminar el primer elemento que es la coincidencia completa
                    array_shift($matches);
                    
                    if ($route['type'] === 'callback') {
                        call_user_func_array($route['handler'], $matches);
                    } elseif ($route['type'] === 'view') {
                        $path = $route['path'];
                        $basePath = __DIR__ . '/../../public/';
                        
                        if (str_starts_with($path, 'pages/inquilino/')) {
                            require_once $basePath . 'pages/inquilino/' . basename($path);
                        } elseif (str_starts_with($path, 'pages/')) {
                            require_once $basePath . 'pages/' . basename($path);
                        } elseif (str_starts_with($path, 'comite/')) {
                            require_once $basePath . 'pages/' . $path;
                        } else {
                            require_once $basePath . ltrim($path, '/');
                        }
                    }
                    return;
                }
            }
            
            // Si no se encontró ninguna coincidencia
            http_response_code(404);
            require_once __DIR__ . '/../../public/pages/NotFound.php';
        }

        $Body = ob_get_clean();
        $Base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        
        require_once __DIR__ . '/../../public/App.php';
    }

    private function handleRoute($route): void {
        if ($route['type'] === 'callback') {
            call_user_func($route['handler']);
        } elseif ($route['type'] === 'view') {
            $path = $route['path'];
            $basePath = __DIR__ . '/../../public/';
            
            if (str_starts_with($path, 'pages/inquilino/')) {
                require_once $basePath . 'pages/inquilino/' . basename($path);
            } elseif (str_starts_with($path, 'pages/')) {
                require_once $basePath . 'pages/' . basename($path);
            } elseif (str_starts_with($path, 'comite/')) {
                require_once $basePath . 'pages/' . $path;
            } else {
                require_once $basePath . ltrim($path, '/');
            }
        }
    }
}
