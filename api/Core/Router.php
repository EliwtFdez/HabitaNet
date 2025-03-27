<?php

namespace Src\Core;

class Router
{
    private $routes = [];
    private $base = '';

    public function __construct() {
        $this->base = dirname($_SERVER['SCRIPT_NAME']);
    }

    public function add($route, $path)
    {
        $this->routes[$route] = $path;
    }

    public function run()
    {
        // Get the current URI without query string
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim(str_replace($this->base, '', $requestUri), '/');
        
        $Base = $this->base;
    
        ob_start();

        $assetPath = realpath(__DIR__ . '/../../public/assets') . '/';
        function asset($url) {
            global $assetPath;
            return $assetPath . $url;
        }
        
        if (array_key_exists($uri, $this->routes)) {
            require_once __DIR__ . '/../../public/pages/' . $this->routes[$uri];
        } else {
            require_once __DIR__ . '/../../public/pages/NotFound.php';
        }
        $Body = ob_get_clean();
        
        require_once __DIR__ . '/../../public/App.php';
    }
}
