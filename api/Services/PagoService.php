<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/Pago.php';
require_once __DIR__ . '/../Core/Conexion.php';

class PagoService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearPago($id_usuario, $id_casa, $fecha_pago, $monto, $recargo_aplicado, $concepto, $comprobante_pago) {
        $stmt = $this->db->prepare("INSERT INTO pagos (id_usuario, id_casa, fecha_pago, monto, recargo_aplicado, concepto, comprobante_pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$id_usuario, $id_casa, $fecha_pago, $monto, $recargo_aplicado, $concepto, $comprobante_pago]);
        return $this->db->lastInsertId();
    }

    public function obtenerPago($id) {
        $stmt = $this->db->prepare("SELECT * FROM pagos WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\Pago(
                $result['id'],
                $result['id_usuario'],
                $result['id_casa'],
                $result['fecha_pago'],
                $result['monto'],
                $result['recargo_aplicado'],
                $result['concepto'],
                $result['comprobante_pago'],
                $result['confirmado_por'],
                $result['fecha_confirmacion']
            );
        }
        return null;
    }

    public function actualizarPago($id, $id_usuario, $id_casa, $fecha_pago, $monto, $recargo_aplicado, $concepto, $comprobante_pago) {
        $stmt = $this->db->prepare("UPDATE pagos SET id_usuario = ?, id_casa = ?, fecha_pago = ?, monto = ?, recargo_aplicado = ?, concepto = ?, comprobante_pago = ? WHERE id = ?");
        return $stmt->execute([$id_usuario, $id_casa, $fecha_pago, $monto, $recargo_aplicado, $concepto, $comprobante_pago, $id]);
    }

    public function eliminarPago($id) {
        $stmt = $this->db->prepare("DELETE FROM pagos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodosLosPagos() {
        $stmt = $this->db->query("SELECT * FROM pagos");
        $pagos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pagos[] = new \Api\Models\Pago(
                $row['id'],
                $row['id_usuario'],
                $row['id_casa'],
                $row['fecha_pago'],
                $row['monto'],
                $row['recargo_aplicado'],
                $row['concepto'],
                $row['comprobante_pago'],
                $row['confirmado_por'],
                $row['fecha_confirmacion']
            );
        }
        return $pagos;
    }

    public function confirmarPago($id, $confirmado_por) {
        $stmt = $this->db->prepare("UPDATE pagos SET confirmado_por = ?, fecha_confirmacion = NOW() WHERE id = ?");
        return $stmt->execute([$confirmado_por, $id]);
    }

    public function obtenerPagosPorUsuario($id_usuario) {
        $stmt = $this->db->prepare("SELECT * FROM pagos WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $pagos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pagos[] = new \Api\Models\Pago(
                $row['id'],
                $row['id_usuario'],
                $row['id_casa'],
                $row['fecha_pago'],
                $row['monto'],
                $row['recargo_aplicado'],
                $row['concepto'],
                $row['comprobante_pago'],
                $row['confirmado_por'],
                $row['fecha_confirmacion']
            );
        }
        return $pagos;
    }

    public function obtenerPagosPorCasa($id_casa) {
        $stmt = $this->db->prepare("SELECT * FROM pagos WHERE id_casa = ?");
        $stmt->execute([$id_casa]);
        $pagos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pagos[] = new \Api\Models\Pago(
                $row['id'],
                $row['id_usuario'],
                $row['id_casa'],
                $row['fecha_pago'],
                $row['monto'],
                $row['recargo_aplicado'],
                $row['concepto'],
                $row['comprobante_pago'],
                $row['confirmado_por'],
                $row['fecha_confirmacion']
            );
        }
        return $pagos;
    }

public static function getPagosPorUsuario($id_usuario) {
    try {
        $conn = Conexion::conectar();

        $query = "SELECT p.*, u.nombre as confirmado_por_nombre 
                  FROM pagos p 
                  LEFT JOIN usuarios u ON p.confirmado_por = u.id 
                  WHERE p.id_usuario = :id_usuario 
                  ORDER BY p.fecha_pago DESC";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        throw new Exception("Error al obtener pagos: " . $e->getMessage());
    }
}



}