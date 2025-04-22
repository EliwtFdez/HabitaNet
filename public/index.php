<?php
// Cargar el autoload de Composer para las dependencias
require_once __DIR__ . '/../vendor/autoload.php';

// Configuración para mostrar errores (solo en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar la sesión
session_start();

// Importar las clases necesarias
use Api\Core\Router;
use Api\Controllers\UserController;

// Crear una nueva instancia del enrutador
$router = new Router();

// ======================
// RUTAS PÚBLICAS
// ======================

// Ruta para la página de inicio
$router->add('', 'home.php');

// Ruta para el login
$router->add('login', 'login.php');

// Ruta para el registro
$router->add('register', 'register.php');

// ======================
// RUTAS PRIVADAS
// ======================

// Ruta para el dashboard (requiere autenticación)
$router->add('dashboard', function() {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login');
        exit;
    }
    // Variable para ocultar el footer en el dashboard
    $hideFooter = true;
    // Cargar la vista del dashboard
    require 'pages/dashboard.php';
});

// Rutas para los módulos principales
$router->add('casas', 'pages/casas.php');
$router->add('residentes', 'pages/residentes.php');
$router->add('facturas', 'pages/facturas.php');
$router->add('pagos', 'pages/pagos.php');
$router->add('informacion', 'pages/informacion.php');
$router->add('mantenimiento', 'pages/mantenimiento.php');
$router->add('comunicacion', 'pages/comunicacion.php');

// ======================
// RUTAS PARA EL COMITÉ
// ======================
$router->add('comite/estadoCuenta', 'pages/comite/estadoCuenta.php');
$router->add('comite/registroEgreso', 'pages/comite/registroEgreso.php');
$router->add('comite/reporteMensual', 'pages/comite/reporteMensual.php');
$router->add('comite/acuseRecibo', 'pages/comite/acuseRecibo.php');

// ======================
// RUTAS PARA INQUILINOS
// ======================
$router->add('inquilino/pagoCuota', 'pages/inquilino/pagoCuota.php');
$router->add('inquilino/reservarEspacio', 'pages/inquilino/reservarEspacio.php');
$router->add('inquilino/solicitarServicio', 'pages/inquilino/solicitarServicio.php');

// ======================
// RUTAS DE LA API
// ======================

// Ruta para registro de usuarios (API)
$router->add('api/register', function() {
    header('Content-Type: application/json');
    $controller = new UserController();
    $response = $controller->register();
    echo json_encode($response);
    exit;
});

// Ruta para login de usuarios (API)
$router->add('api/login', function() {
    header('Content-Type: application/json');
    $controller = new UserController();
    $response = $controller->login();
    echo json_encode($response);
    exit;
});

// Ruta para logout (API)
$router->add('api/logout', function() {
    header('Content-Type: application/json');
    $controller = new UserController();
    $controller->logout();
});

// Ruta para obtener todos los usuarios (API)
$router->add('api/users', function() {
    header('Content-Type: application/json');
    $controller = new UserController();
    $response = $controller->getAllUsers();
    echo json_encode($response);
    exit;
});

// Ruta para obtener un usuario específico (API)
$router->add('api/users/(\d+)', function($id) {
    header('Content-Type: application/json');
    $controller = new UserController();
    $controller->getUser($id);
});

// Ruta para actualizar un usuario (API)
$router->add('api/users/(\d+)/update', function($id) {
    header('Content-Type: application/json');
    $controller = new UserController();
    $controller->updateUser($id);
});

// Ruta para eliminar un usuario (API)
$router->add('api/users/(\d+)/delete', function($id) {
    header('Content-Type: application/json');
    $controller = new UserController();
    $controller->deleteUser($id);
});

// Ruta para actualizar contraseña (API)
$router->add('api/users/(\d+)/password', function($id) {
    header('Content-Type: application/json');
    $controller = new UserController();
    $controller->updatePassword($id);
});

// ======================
// RUTA PARA CERRAR SESIÓN
// ======================
$router->add('logout', function() {
    session_start();
    session_destroy();
    header('Location: login');
    exit;
});

// Arrays para scripts y estilos (pueden ser usados en las vistas)
$Scripts = [];
$Styles = [];

// Ejecutar el enrutador
$router->run();
