<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Models/Cuota.php';
require_once __DIR__ . '/../Core/Conexion.php';

class CuotaService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function crearCuota($monto, $recargo, $mes, $anio) {
        $stmt = $this->db->prepare("INSERT INTO cuotas (monto, recargo, mes, anio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$monto, $recargo, $mes, $anio]);
        return $this->db->lastInsertId();
    }

    public function obtenerCuota($id) {
        $stmt = $this->db->prepare("SELECT * FROM cuotas WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\Cuota(
                $result['id'],
                $result['monto'],
                $result['recargo'],
                $result['mes'],
                $result['anio']
            );
        }
        return null;
    }

    public function actualizarCuota($id, $monto, $recargo, $mes, $anio) {
        $stmt = $this->db->prepare("UPDATE cuotas SET monto = ?, recargo = ?, mes = ?, anio = ? WHERE id = ?");
        return $stmt->execute([$monto, $recargo, $mes, $anio, $id]);
    }

    public function eliminarCuota($id) {
        $stmt = $this->db->prepare("DELETE FROM cuotas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function obtenerTodasLasCuotas() {
        $stmt = $this->db->query("SELECT * FROM cuotas");
        $cuotas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cuotas[] = new \Api\Models\Cuota(
                $row['id'],
                $row['monto'],
                $row['recargo'],
                $row['mes'],
                $row['anio']
            );
        }
        return $cuotas;
    }

    public function obtenerCuotaPorMesAnio($mes, $anio) {
        $stmt = $this->db->prepare("SELECT * FROM cuotas WHERE mes = ? AND anio = ?");
        $stmt->execute([$mes, $anio]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new \Api\Models\Cuota(
                $result['id'],
                $result['monto'],
                $result['recargo'],
                $result['mes'],
                $result['anio']
            );
        }
        return null;
    }
} 