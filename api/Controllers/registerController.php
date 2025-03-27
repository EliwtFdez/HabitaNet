<?php
namespace Controllers;

class RegisterController
{
    public function index()
    {
        require 'pages/register/register.php';
    }

    public function register()
    {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Here goes validation logic, user creation, etc.
        if ($password === $confirmPassword) {
            // TODO: Add password hashing and database storage
            echo "Registration processed for user: $username";
        } else {
            echo "Passwords do not match";
        }
    }
}
