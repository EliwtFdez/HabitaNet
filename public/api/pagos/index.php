<?php
// Autocarga de clases (ajusta la ruta según tu estructura)
require_once __DIR__ . '/../../../vendor/autoload.php'; // Si usas Composer
require_once __DIR__ . '/../../../api/Controllers/PagoController.php';
require_once __DIR__ . '/../../../api/Services/PagoService.php';
require_once __DIR__ . '/../../../api/Core/Conexion.php';
// Agrega otros require_once necesarios si no usas autoload

// Solo permitir método POST para la creación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instanciar el controlador
    $controller = new Api\Controllers\PagoController();
    // Llamar al método para crear el pago
    $controller->crearPago();
} else {
    // Manejar otros métodos o devolver error si solo se espera POST
    header('Content-Type: application/json');
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}

// Solo permitir método POST para la creación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Instanciar el controlador
    $controller = new Api\Controllers\PagoController();
    // Llamar al método para crear el pago
    $controller->crearPago();
} else {
    // Manejar otros métodos o devolver error si solo se espera POST
    header('Content-Type: application/json');
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}