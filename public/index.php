
<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

use Src\Core\Router;

$router = new Router();

// Define routes
$router->add('', 'home/home.php');
$router->add('login', 'login/login.php');
$router->add('register', 'register/register.php');

// Set variables for template
$Scripts = [
    'assets/js/main.js'  // Add your JS files here
];

$Styles = [
    'assets/css/custom.css'  // Add your CSS files here
];

$router->run();
