<?php
// Verificar y asegurar que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir helpers de autenticación
require_once __DIR__ . '/../includes/auth.php';
// Incluir el modelo de usuario para autenticación
require_once __DIR__ . '/../../api/Models/UserModel.php';
use Api\Models\UserModel;

// Verificar si el usuario está autenticado
if (!isLoggedIn()) {
    session_destroy();
    header('Location: login');
    exit;
}

// Validar el rol del usuario
if (!isComite() && !isInquilino()) {
    error_log("Rol no permitido: " . (getUserRole() ?: 'NULL'));
    header('Location: register');
    exit;
}

// Redirección automática a la primera opción del menú según el rol
if (isComite()) {
    header('Location: /HabitaNet/public/comite/estadoCuenta');
    exit;
} elseif (isInquilino()) {
    header('Location: /HabitaNet/public/inquilino/pagoCuota');
    exit;
}

?>
