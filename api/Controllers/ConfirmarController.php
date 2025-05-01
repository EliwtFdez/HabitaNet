<?php
namespace Api\Controllers;

use Api\Services\ConfirmarService;

class ConfirmarController {
    private $confirmarService;

    public function __construct() {
        $this->confirmarService = new ConfirmarService();
    }

    public function confirmarPago($id_pago, $id_usuario) {
        try {
            // Validar el ID del pago
            $this->confirmarService->validarConfirmacion($id_pago);

            // Intentar confirmar el pago
            $resultado = $this->confirmarService->confirmarPago($id_pago, $id_usuario);
            
            if ($resultado) {
                return [
                    'success' => true,
                    'mensaje' => 'Pago confirmado exitosamente'
                ];
            } else {
                return [
                    'success' => false,
                    'error' => 'Error al confirmar el pago'
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
} 