<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/SolicitudServicio.php';
require_once __DIR__ . '/../Core/Conexion.php';

class SolicitudServicioService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearSolicitud($id_usuario, $tipo, $fecha_solicitud, $comentario) {
        $stmt = $this->db->prepare("INSERT INTO solicitudes_servicios (id_usuario, tipo, fecha_solicitud, comentario) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $tipo, $fecha_solicitud, $comentario]);
        return $this->db->lastInsertId();
    }

    public function obtenerSolicitud($id) {
        $stmt = $this->db->prepare("SELECT * FROM solicitudes_servicios WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\SolicitudServicio(
                $result['id'],
                $result['id_usuario'],
                $result['tipo'],
                $result['fecha_solicitud'],
                $result['comentario'],
                $result['estatus'],
                $result['respuesta'],
                $result['fecha_respuesta']
            );
        }
        return null;
    }

    public function actualizarSolicitud($id, $tipo, $comentario) {
        $stmt = $this->db->prepare("UPDATE solicitudes_servicios SET tipo = ?, comentario = ? WHERE id = ?");
        return $stmt->execute([$tipo, $comentario, $id]);
    }

    public function eliminarSolicitud($id) {
        $stmt = $this->db->prepare("DELETE FROM solicitudes_servicios WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodasLasSolicitudes() {
        $stmt = $this->db->query("SELECT * FROM solicitudes_servicios");
        $solicitudes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $solicitudes[] = new \Api\Models\SolicitudServicio(
                $row['id'],
                $row['id_usuario'],
                $row['tipo'],
                $row['fecha_solicitud'],
                $row['comentario'],
                $row['estatus'],
                $row['respuesta'],
                $row['fecha_respuesta']
            );
        }
        return $solicitudes;
    }

    public function obtenerSolicitudesPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM solicitudes_servicios WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $solicitudes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $solicitudes[] = new \Api\Models\SolicitudServicio(
                $row['id'],
                $row['id_usuario'],
                $row['tipo'],
                $row['fecha_solicitud'],
                $row['comentario'],
                $row['estatus'],
                $row['respuesta'],
                $row['fecha_respuesta']
            );
        }
        return $solicitudes;
    }

    public function actualizarEstatus($id, $estatus, $respuesta = null) {
        $stmt = $this->db->prepare("UPDATE solicitudes_servicios SET estatus = ?, respuesta = ?, fecha_respuesta = NOW() WHERE id = ?");
        return $stmt->execute([$estatus, $respuesta, $id]);
    }

    public function obtenerSolicitudesPorEstatus($estatus) {
        $stmt = $this->db->prepare("SELECT * FROM solicitudes_servicios WHERE estatus = ?");
        $stmt->execute([$estatus]);
        $solicitudes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $solicitudes[] = new \Api\Models\SolicitudServicio(
                $row['id'],
                $row['id_usuario'],
                $row['tipo'],
                $row['fecha_solicitud'],
                $row['comentario'],
                $row['estatus'],
                $row['respuesta'],
                $row['fecha_respuesta']
            );
        }
        return $solicitudes;
    }

    public function obtenerSolicitudesPorTipo($tipo) {
        $stmt = $this->db->prepare("SELECT * FROM solicitudes_servicios WHERE tipo = ?");
        $stmt->execute([$tipo]);
        $solicitudes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $solicitudes[] = new \Api\Models\SolicitudServicio(
                $row['id'],
                $row['id_usuario'],
                $row['tipo'],
                $row['fecha_solicitud'],
                $row['comentario'],
                $row['estatus'],
                $row['respuesta'],
                $row['fecha_respuesta']
            );
        }
        return $solicitudes;
    }
} 