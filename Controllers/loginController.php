<?php
namespace Controllers;

class LoginController
{
    public function index()
    {
        require 'pages/login/login.php';
    }

    public function login()
    {
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';

        // Aquí va la lógica de validación, sesión, etc.
        echo "Login procesado para $user";
    }

}
