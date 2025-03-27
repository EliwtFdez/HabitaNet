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
        $uri = trim($_GET['url'] ?? '', '/');
        
        // Set base path for assets
        $Base = $this->base;
        
        // Load content into $Body
        ob_start();
        if (array_key_exists($uri, $this->routes)) {
            require_once __DIR__ . '/../../public/pages/' . $this->routes[$uri];
        } else {
            require_once __DIR__ . '/../../public/pages/NotFound.php';
        }
        $Body = ob_get_clean();
        
        // Load the template with the content
        require_once __DIR__ . '/../../public/App.php';
    }
}
