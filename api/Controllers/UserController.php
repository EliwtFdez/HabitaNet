<?php
namespace Api\Controllers;

use Api\Models\UserModel;

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function register() {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['nombre']) || !isset($data['email']) || !isset($data['password']) || !isset($data['rol'])) {
            http_response_code(400);
            return ['error' => 'Faltan datos requeridos'];
        }

        if ($this->model->create($data['nombre'], $data['email'], $data['password'], $data['rol'])) {
            http_response_code(201);
            return ['message' => 'Usuario creado exitosamente'];
        } else {
            http_response_code(500);
            return ['error' => 'Error al crear el usuario'];
        }
    }

    public function login() {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Email y contraseña son requeridos']);
            return;
        }

        $user = $this->model->authenticate($data['email'], $data['password']);
        
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_rol'] = $user['rol'];
            
            echo json_encode([
                'message' => 'Login exitoso',
                'user' => $user
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciales inválidas']);
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        echo json_encode(['message' => 'Sesión cerrada exitosamente']);
    }

    public function getUser($id) {
        header('Content-Type: application/json');
        
        $user = $this->model->getById($id);
        
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }

    public function updateUser($id) {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(['error' => 'No hay datos para actualizar']);
            return;
        }

        if ($this->model->update($id, $data)) {
            echo json_encode(['message' => 'Usuario actualizado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar el usuario']);
        }
    }

    public function deleteUser($id) {
        header('Content-Type: application/json');
        
        if ($this->model->delete($id)) {
            echo json_encode(['message' => 'Usuario eliminado exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar el usuario']);
        }
    }

    public function getAllUsers() {
        header('Content-Type: application/json');
        return $this->model->getAll(); // Return data instead of echoing
    }

    public function updatePassword($id) {
        header('Content-Type: application/json');
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['new_password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Nueva contraseña es requerida']);
            return;
        }

        if ($this->model->updatePassword($id, $data['new_password'])) {
            echo json_encode(['message' => 'Contraseña actualizada exitosamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar la contraseña']);
        }
    }
}