<?php
session_start();

// Base URL configuration
$Base = rtrim(dirname($_SERVER['PHP_SELF']), '/');

// Assets arrays
$Styles = [];
$Scripts = [];

// Get the current route
$route = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$route = substr($route, strlen(trim(dirname($_SERVER['PHP_SELF']), '/')));
$route = trim($route, '/');

// Get routes configuration
$routes = require 'routes.php';

// Prepare the content
ob_start();
if (isset($routes[$route])) {
    $routes[$route]();
} else {
    // 404 page or redirect to home
    header('Location: ' . $Base);
}
$Body = ob_get_clean();

// Load the main template
require 'App.php';