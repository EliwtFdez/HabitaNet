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
        // Usar cadena vacía si 'url' no está presente (acceso directo a index.php o la raíz)
        $uri = $_GET['url'] ?? ''; 
        $uri = trim($uri, '/'); // Limpiar slashes al inicio/final
    
        // --- Línea de depuración NO TOCAR ---
        // Muestra la URI que el router está intentando procesar. 
        // Puedes comentar o eliminarla después de depurar.
         error_log("Router URI procesada: '" . $uri . "'"); // Escribe en el log de errores de PHP/Apache
        // echo "<pre>Debug: URI procesada = '" . htmlspecialchars($uri) . "'</pre>"; // Muestra directamente en la página (¡cuidado si interfiere con JSON!)
        // --- Fin de línea de depuración ---
    
        ob_start();
    
        if (isset($this->routes[$uri])) {
            $route = $this->routes[$uri];
            
            if ($route['type'] === 'callback') {
                call_user_func($route['handler']);
            } elseif ($route['type'] === 'view') {
                $path = $route['path'];
                $basePath = __DIR__ . '/../../public/'; // Ruta base a la carpeta public

                // Lógica para determinar la ruta completa del archivo de vista
                if (str_starts_with($path, 'pages/inquilino/')) {
                    require_once $basePath . 'pages/inquilino/' . basename($path);
                } elseif (str_starts_with($path, 'pages/')) {
                    require_once $basePath . 'pages/' . basename($path);
                } elseif (str_starts_with($path, 'comite/')) {
                    // Corrected path construction for 'comite/' routes
                    require_once $basePath . 'pages/' . $path; 
                } else {
                    // Si no tiene prefijo conocido, buscar directamente en public
                    require_once $basePath . ltrim($path, '/');
                }
            }
        } else {
            // Ruta no encontrada, establecer código de estado 404 y mostrar página
            http_response_code(404); 
            // Ensure NotFound page path is correct relative to Router.php
            require_once __DIR__ . '/../../public/pages/NotFound.php'; 
        }

        $Body = ob_get_clean();
        // Calcular la ruta base para usar en App.php (ej. para assets)
        // Se basa en el directorio del script index.php
        $Base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); 
        
        require_once __DIR__ . '/../../public/App.php';
    }
}
