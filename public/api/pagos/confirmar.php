<?php
require_once __DIR__ . '/../../../includes/auth.php';
require_once __DIR__ . '/../../../api/Controllers/ConfirmarController.php';

// Verificar si el usuario está autenticado y es comité
if (!isLoggedIn() || !isComite()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

// Obtener el ID del pago de la URL
$url_parts = explode('/', $_SERVER['REQUEST_URI']);
$id_pago = end($url_parts);

try {
    $controller = new \Api\Controllers\ConfirmarController();
    $resultado = $controller->confirmarPago($id_pago, $_SESSION['user_id']);
    
    if (!$resultado['success']) {
        http_response_code(400);
    }
    
    echo json_encode($resultado);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 