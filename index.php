<?php

require_once 'Controllers/LoginController.php';
require_once 'Controllers/RegisterController.php';
require_once 'Controllers/HomeController.php';

function defineRoutes($router)
{
    $router->get('/', [new \Controllers\DefaulController(), 'index']);
    $router->get('/login', [new \Controllers\LoginController(), 'index']);
    $router->post('/login', [new \Controllers\LoginController(), 'login']);
    
    $router->get('/home', [new \Controllers\DefaulController(), 'index']);
    
    $router->get('/register', [new \Controllers\RegisterController(), 'index']);
    $router->post('/register', [new \Controllers\RegisterController(), 'register']);
}

$router = new Router();
defineRoutes($router);

// Get the current request URI and dispatch to appropriate controller
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($requestUri);
