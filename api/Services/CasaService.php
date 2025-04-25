<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/Casa.php';
require_once __DIR__ . '/../Core/Conexion.php';

class CasaService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearCasa($numero_casa, $id_inquilino = null) {
        $stmt = $this->db->prepare("INSERT INTO casas (numero_casa, id_inquilino) VALUES (?, ?)");
        $stmt->execute([$numero_casa, $id_inquilino]);
        return $this->db->lastInsertId();
    }

    public function obtenerCasa($id) {
        $stmt = $this->db->prepare("SELECT * FROM casas WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\Casa($result['id'], $result['numero_casa'], $result['id_inquilino']);
        }
        return null;
    }

    public function actualizarCasa($id, $numero_casa, $id_inquilino = null) {
        $stmt = $this->db->prepare("UPDATE casas SET numero_casa = ?, id_inquilino = ? WHERE id = ?");
        return $stmt->execute([$numero_casa, $id_inquilino, $id]);
    }

    public function eliminarCasa($id) {
        $stmt = $this->db->prepare("DELETE FROM casas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodasLasCasas() {
        $stmt = $this->db->query("SELECT * FROM casas");
        $casas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $casas[] = new \Api\Models\Casa($row['id'], $row['numero_casa'], $row['id_inquilino']);
        }
        return $casas;
    }

    public function obtenerCasasDisponibles() {
        $stmt = $this->db->query("SELECT * FROM casas WHERE id_inquilino IS NULL");
        $casas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $casas[] = new \Api\Models\Casa($row['id'], $row['numero_casa'], $row['id_inquilino']);
        }
        return $casas;
    }
} 