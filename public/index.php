<?php
// Cargar el autoload de Composer para las dependencias
require_once __DIR__ . '/../vendor/autoload.php';

// Configuración para mostrar errores (solo en desarrollo)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Manejador de errores personalizado para API
function handleError($errno, $errstr, $errfile, $errline) {
    if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => $errstr,
            'file' => basename($errfile),
            'line' => $errline
        ]);
        exit;
    }
    return false;
}

set_error_handler('handleError');

// Iniciar la sesión
session_start();

// Importar las clases necesarias
use Api\Core\Router;
use Api\Controllers\UserController;
use Api\Controllers\CasaController;
use Api\Controllers\CuotaController;
use Api\Controllers\PagoController;

// Crear una nueva instancia del enrutador
$router = new Router();

// ======================
// RUTAS PÚBLICAS
// ======================

// Ruta para la página de inicio
$router->add('', 'pages/home.php');

// Ruta para el login
$router->add('login', 'pages/login.php');

// Ruta para el registro
$router->add('register', 'pages/register.php');

// Ruta para procesar pagos
$router->add('procesar_pago', 'pages/comprobantes/procesar_pago.php');


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
$router->add('comite/estadoCuenta', 'comite/estadoCuenta.php');
$router->add('comite/cuotas', 'comite/cuotas.php');
$router->add('comite/reportes', 'comite/reportes.php');
$router->add('comite/acuseRecibo', 'comite/acuseRecibo.php');
$router->add('comite/usuariosCasas', 'comite/usuariosCasas.php');
$router->add('comite/registroCasa', 'comite/registoCasa.php'); // O $router->add('comite/registoCasa', 'comite/registoCasa.php');

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

// RUTAS PARA CASAS
// ======================

// Ruta para obtener todas las casas (API)
$router->add('api/casas', function() {
    header('Content-Type: application/json');
    $controller = new CasaController();
    $controller->handleRequest('GET');
});

// Ruta para obtener una casa específica (API)
$router->add('api/casas/(\d+)', function($id) {
    header('Content-Type: application/json');
    $controller = new CasaController();
    $controller->handleRequest('GET', $id);
});

// Ruta para crear una nueva casa (API)
$router->add('api/casas/create', function() {
    header('Content-Type: application/json');
    $controller = new CasaController();
    $controller->handleRequest('POST');
});

// Ruta para actualizar una casa (API)
$router->add('api/casas/(\d+)/update', function($id) {
    header('Content-Type: application/json');
    $controller = new CasaController();
    $controller->handleRequest('PUT', $id);
});

// Ruta para eliminar una casa (API)
$router->add('api/casas/(\d+)/delete', function($id) {
    header('Content-Type: application/json');
    $controller = new CasaController();
    $controller->handleRequest('DELETE', $id);
});

// Ruta para obtener casas disponibles (API)
$router->add('api/casas/disponibles', function() {
    header('Content-Type: application/json');
    $controller = new CasaController();
    $controller->handleRequest('GET', 'disponibles');
});

// RUTAS PARA CUOTAS
// ======================

// Ruta para obtener todas las cuotas (API)
$router->add('api/cuotas', function() {
    header('Content-Type: application/json');
    $controller = new CuotaController();
    $controller->handleRequest('GET');
});

// Ruta para obtener una cuota específica (API)
$router->add('api/cuotas/(\d+)', function($id) {
    header('Content-Type: application/json');
    $controller = new CuotaController();
    $controller->handleRequest('GET', $id);
});

// Ruta para crear una nueva cuota (API)
$router->add('api/cuotas/create', function() {
    header('Content-Type: application/json');
    $controller = new CuotaController();
    $controller->handleRequest('POST');
});

// Ruta para actualizar una cuota (API)
$router->add('api/cuotas/(\d+)/update', function($id) {
    header('Content-Type: application/json');
    $controller = new CuotaController();
    $controller->handleRequest('PUT', $id);
});

// Ruta para eliminar una cuota (API)
$router->add('api/cuotas/(\d+)/delete', function($id) {
    header('Content-Type: application/json');
    $controller = new CuotaController();
    $controller->handleRequest($_SERVER['REQUEST_METHOD'], $id); // ✅ usar método real
});

// Ruta para obtener estado de cuenta
$router->add('api/usuarios/(\d+)/estadoCuenta', function($id_usuario) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new PagoController();
    $controller->getEstadoCuenta($id_usuario);
});

// Ruta para obtener pagos por usuario
$router->add('api/pagos/usuario/(\d+)', function($id_usuario) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new PagoController();
    $controller->getPagosPorUsuario($id_usuario);
});

// Ruta para registrar pago (API)
$router->add('api/pagos', function() {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
        exit;
    }
    
    $controller = new PagoController();
    $controller->registrarPago();
});

// Ruta para confirmar pago (API)
$router->add('api/pagos/(\d+)/confirmar', function($id_pago) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
        exit;
    }
    
    $controller = new \Api\Controllers\ConfirmarController();
    $resultado = $controller->confirmarPago($id_pago, $_SESSION['user_id']);
    
    if (!$resultado['success']) {
        http_response_code(400);
    }
    
    echo json_encode($resultado);
});

// ======================
$router->add('api/mensajes', function() {

// RUTA PARA CERRAR SESIÓN
// ======================
$router->add('logout', function() {
    session_start();
    session_destroy();
    header('Location: login');
    exit;
});

// RUTAS PARA MENSAJES DEL FORO
// ======================

// Ruta para obtener todos los mensajes (API)
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->handleRequest('GET');
});

// Ruta para obtener un mensaje específico (API)
$router->add('api/mensajes/(\d+)', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->handleRequest('GET', $id);
});

// Ruta para crear un nuevo mensaje (API)
$router->add('api/mensajes/create', function() {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->handleRequest('POST');
});

// Ruta para actualizar un mensaje (API)
$router->add('api/mensajes/(\d+)/update', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->handleRequest('PUT', $id);
});

// Ruta para eliminar un mensaje (API)
$router->add('api/mensajes/(\d+)/delete', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->handleRequest('DELETE', $id);
});

// Ruta para obtener mensajes por usuario (API)
$router->add('api/mensajes/usuario/(\d+)', function($id_usuario) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->obtenerMensajesPorUsuario($id_usuario);
});

// Ruta para ocultar un mensaje (API)
$router->add('api/mensajes/(\d+)/ocultar', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->ocultarMensaje($id);
});

// Ruta para obtener mensajes recientes (API)
$router->add('api/mensajes/recientes/(\d+)', function($limite) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\MensajeForoController();
    $controller->obtenerMensajesRecientes($limite);
});

// RUTAS PARA SOLICITUDES DE SERVICIO
// ======================

// Ruta para obtener todas las solicitudes (API)
$router->add('api/solicitudes', function() {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->handleRequest('GET');
});

// Ruta para obtener una solicitud específica (API)
$router->add('api/solicitudes/(\d+)', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->handleRequest('GET', $id);
});

// Ruta para crear una nueva solicitud (API)
$router->add('api/solicitudes/create', function() {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->handleRequest('POST');
});

// Ruta para actualizar una solicitud (API)
$router->add('api/solicitudes/(\d+)/update', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->handleRequest('PUT', $id);
});

// Ruta para eliminar una solicitud (API)
$router->add('api/solicitudes/(\d+)/delete', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->handleRequest('DELETE', $id);
});

// Ruta para obtener solicitudes por usuario (API)
$router->add('api/solicitudes/usuario/(\d+)', function($id_usuario) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->obtenerSolicitudesPorUsuario($id_usuario);
});

// Ruta para actualizar el estatus de una solicitud (API)
$router->add('api/solicitudes/(\d+)/estatus', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->actualizarEstatus($id);
});

// Ruta para obtener solicitudes por estatus (API)
$router->add('api/solicitudes/estatus/(\w+)', function($estatus) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->obtenerSolicitudesPorEstatus($estatus);
});

// Ruta para obtener solicitudes por tipo (API)
$router->add('api/solicitudes/tipo/(\w+)', function($tipo) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\SolicitudServicioController();
    $controller->obtenerSolicitudesPorTipo($tipo);
});

// RUTAS PARA EGRESOS
// ======================

// Ruta para obtener todos los egresos (API)
$router->add('api/egresos', function() {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->handleRequest('GET');
});

// Ruta para obtener un egreso específico (API)
$router->add('api/egresos/(\d+)', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->handleRequest('GET', $id);
});

// Ruta para crear un nuevo egreso (API)
$router->add('api/egresos/create', function() {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->handleRequest('POST');
});

// Ruta para actualizar un egreso (API)
$router->add('api/egresos/(\d+)/update', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->handleRequest('PUT', $id);
});

// Ruta para eliminar un egreso (API)
$router->add('api/egresos/(\d+)/delete', function($id) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->handleRequest('DELETE', $id);
});

// Ruta para obtener egresos por usuario (API)
$router->add('api/egresos/usuario/(\d+)', function($id_usuario) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->obtenerEgresosPorUsuario($id_usuario);
});

// Ruta para obtener egresos por fecha (API)
$router->add('api/egresos/fecha/(\d{4}-\d{2}-\d{2})/(\d{4}-\d{2}-\d{2})', function($fecha_inicio, $fecha_fin) {
    header('Content-Type: application/json');
    $controller = new \Api\Controllers\EgresoController();
    $controller->obtenerEgresosPorFecha($fecha_inicio, $fecha_fin);
});

// Rutas para usuarios
$router->add('api/usuarios/(\d+)/estadoCuenta', function($id) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new \Api\Controllers\UsuarioController();
    $controller->getEstadoCuenta($id);
});

// Rutas para pagos
$router->add('api/pagos', function() {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new \Api\Controllers\PagoController();
    $controller->registrarPago();
});

$router->add('api/pagos', function() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        // Asegúrate que el namespace sea correcto
        $controller = new Api\Controllers\PagoController();
        $controller->crearPago(); // Llamar al método que maneja POST
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'error' => 'Método no permitido. Se requiere POST.']);
    }
    exit;
}, 'post'); // ¡Importante especificar 'post'!

$router->add('api/pagos', function() {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new \Api\Controllers\PagoController();
    $controller->registrarPago();
});

// RUTAS PARA PAGOS Y ESTADO DE CUENTA
// ======================

// Ruta para obtener estado de cuenta (API)
$router->add('api/usuarios/(\d+)/estadoCuenta', function($id_usuario) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new PagoController();
    $controller->getEstadoCuenta($id_usuario);
});

// Ruta para obtener pagos por usuario (API)
$router->add('api/pagos/usuario/(\d+)', function($id_usuario) {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    $controller = new PagoController();
    $controller->getPagosPorUsuario($id_usuario);
});

// Ruta para registrar pago (API)
$router->add('api/pagos', function() {
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
    header("Access-Control-Allow-Credentials: true");
    
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
        exit;
    }
    
    $controller = new PagoController();
    $controller->registrarPago();
});

// Arrays para scripts y estilos (pueden ser usados en las vistas)
$Scripts = [];
$Styles = [];

// Ejecutar el enrutador
$router->run();
