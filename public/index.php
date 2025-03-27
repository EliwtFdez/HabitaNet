
<?php
require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

use Src\Core\Router;

$router = new Router();


$router->add('', 'home.php');
$router->add('login', 'login.php');
$router->add('register', 'register.php');

$Scripts = [
];

$Styles = [
];

$router->run();
