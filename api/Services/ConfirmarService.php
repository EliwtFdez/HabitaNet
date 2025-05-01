<?php
namespace Api\Services;

use PDO;
require_once __DIR__ . '/../Core/Conexion.php';

class ConfirmarService {
    private $db;

    public function __construct() {
        $this->db = \Api\Core\Conexion::conectar();
    }

    public function confirmarPago($id_pago, $id_usuario) {
        try {
            // Verificar si el pago existe y no está confirmado
            $stmt = $this->db->prepare("SELECT id, confirmado_por FROM pagos WHERE id = ?");
            $stmt->execute([$id_pago]);
            $pago = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$pago) {
                throw new \Exception('El pago no existe');
            }

            if ($pago['confirmado_por']) {
                throw new \Exception('El pago ya está confirmado');
            }

            // Confirmar el pago
            $stmt = $this->db->prepare("UPDATE pagos SET confirmado_por = ?, fecha_confirmacion = NOW() WHERE id = ?");
            return $stmt->execute([$id_usuario, $id_pago]);
        } catch (\Exception $e) {
            throw new \Exception('Error al confirmar el pago: ' . $e->getMessage());
        }
    }

    public function validarConfirmacion($id_pago) {
        if (!is_numeric($id_pago)) {
            throw new \Exception('ID de pago inválido');
        }
        return true;
    }
} 