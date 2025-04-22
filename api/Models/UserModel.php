<?php
namespace Api\Models;

use Api\Core\Conexion;
use PDO;

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function create($nombre, $email, $password, $rol) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':rol' => $rol
        ]);
    }

    public function authenticate($email, $password) {
        $query = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // No devolver la contraseña
            return $user;
        }
        return false;
    }

    public function getById($id) {
        $query = "SELECT id, nombre, email, rol, creado_en FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $allowedFields = ['nombre', 'email', 'rol'];
        $updates = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $query = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function delete($id) {
        $query = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    public function getAll() {
        $query = "SELECT id, nombre, email, rol, creado_en FROM usuarios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':password' => $hashedPassword
        ]);
    }

    public function getDb() {
        return $this->db;
    }
}