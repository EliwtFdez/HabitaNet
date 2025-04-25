<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/MensajeForo.php';
require_once __DIR__ . '/../Core/Conexion.php';

class MensajeForoService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearMensaje($id_usuario, $mensaje) {
        $stmt = $this->db->prepare("INSERT INTO mensajes_foro (id_usuario, mensaje) VALUES (?, ?)");
        $stmt->execute([$id_usuario, $mensaje]);
        return $this->db->lastInsertId();
    }

    public function obtenerMensaje($id) {
        $stmt = $this->db->prepare("SELECT * FROM mensajes_foro WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\MensajeForo(
                $result['id'],
                $result['id_usuario'],
                $result['mensaje'],
                $result['fecha'],
                $result['visible']
            );
        }
        return null;
    }

    public function actualizarMensaje($id, $mensaje) {
        $stmt = $this->db->prepare("UPDATE mensajes_foro SET mensaje = ? WHERE id = ?");
        return $stmt->execute([$mensaje, $id]);
    }

    public function eliminarMensaje($id) {
        $stmt = $this->db->prepare("DELETE FROM mensajes_foro WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodosLosMensajes() {
        $stmt = $this->db->query("SELECT * FROM mensajes_foro WHERE visible = TRUE ORDER BY fecha DESC");
        $mensajes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $mensajes[] = new \Api\Models\MensajeForo(
                $row['id'],
                $row['id_usuario'],
                $row['mensaje'],
                $row['fecha'],
                $row['visible']
            );
        }
        return $mensajes;
    }

    public function obtenerMensajesPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM mensajes_foro WHERE id_usuario = ? AND visible = TRUE ORDER BY fecha DESC");
        $stmt->execute([$id_usuario]);
        $mensajes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $mensajes[] = new \Api\Models\MensajeForo(
                $row['id'],
                $row['id_usuario'],
                $row['mensaje'],
                $row['fecha'],
                $row['visible']
            );
        }
        return $mensajes;
    }

    public function ocultarMensaje($id) {
        $stmt = $this->db->prepare("UPDATE mensajes_foro SET visible = FALSE WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerMensajesRecientes($limite = 10) {
        $stmt = $this->db->prepare("SELECT * FROM mensajes_foro WHERE visible = TRUE ORDER BY fecha DESC LIMIT ?");
        $stmt->execute([$limite]);
        $mensajes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $mensajes[] = new \Api\Models\MensajeForo(
                $row['id'],
                $row['id_usuario'],
                $row['mensaje'],
                $row['fecha'],
                $row['visible']
            );
        }
        return $mensajes;
    }
} 