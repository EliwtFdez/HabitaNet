<?php
session_start();

// Puedes reemplazar esto por datos desde MySQL si quieres
$usuarios = [
    'admin' => '1234',
    'demo' => 'demo'
];

$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $clave) {
    $_SESSION['usuario'] = $usuario;
    header("Location: ../../index.php");
} else {
    echo "Credenciales incorrectas. <a href='../../index.php?page=login'>Volver</a>";
}
