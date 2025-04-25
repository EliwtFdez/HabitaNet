<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/Egreso.php';
require_once __DIR__ . '/../Core/Conexion.php';

class EgresoService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearEgreso($fecha, $monto, $motivo, $pagado_a, $registrado_por) {
        $stmt = $this->db->prepare("INSERT INTO egresos (fecha, monto, motivo, pagado_a, registrado_por) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fecha, $monto, $motivo, $pagado_a, $registrado_por]);
        return $this->db->lastInsertId();
    }

    public function obtenerEgreso($id) {
        $stmt = $this->db->prepare("SELECT * FROM egresos WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\Egreso(
                $result['id'],
                $result['fecha'],
                $result['monto'],
                $result['motivo'],
                $result['pagado_a'],
                $result['registrado_por']
            );
        }
        return null;
    }

    public function actualizarEgreso($id, $fecha, $monto, $motivo, $pagado_a) {
        $stmt = $this->db->prepare("UPDATE egresos SET fecha = ?, monto = ?, motivo = ?, pagado_a = ? WHERE id = ?");
        return $stmt->execute([$fecha, $monto, $motivo, $pagado_a, $id]);
    }

    public function eliminarEgreso($id) {
        $stmt = $this->db->prepare("DELETE FROM egresos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodosLosEgresos() {
        $stmt = $this->db->query("SELECT * FROM egresos");
        $egresos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $egresos[] = new \Api\Models\Egreso(
                $row['id'],
                $row['fecha'],
                $row['monto'],
                $row['motivo'],
                $row['pagado_a'],
                $row['registrado_por']
            );
        }
        return $egresos;
    }

    public function obtenerEgresosPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM egresos WHERE registrado_por = ?");
        $stmt->execute([$id_usuario]);
        $egresos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $egresos[] = new \Api\Models\Egreso(
                $row['id'],
                $row['fecha'],
                $row['monto'],
                $row['motivo'],
                $row['pagado_a'],
                $row['registrado_por']
            );
        }
        return $egresos;
    }

    public function obtenerEgresosPorFecha($fecha_inicio, $fecha_fin) {
        $stmt = $this->db->prepare("SELECT * FROM egresos WHERE fecha BETWEEN ? AND ?");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $egresos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $egresos[] = new \Api\Models\Egreso(
                $row['id'],
                $row['fecha'],
                $row['monto'],
                $row['motivo'],
                $row['pagado_a'],
                $row['registrado_por']
            );
        }
        return $egresos;
    }
} 