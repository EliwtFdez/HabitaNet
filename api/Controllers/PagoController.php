<?php
namespace Api\Controllers;

require_once __DIR__ . '/../Services/PagoService.php';

class PagoController {
    private $pagoService;

    public function __construct() {
        $this->pagoService = new \Api\Services\PagoService();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->obtenerPago($id);
                } else {
                    $this->obtenerTodosLosPagos();
                }
                break;
            case 'POST':
                $this->crearPago();
                break;
            case 'PUT':
                if ($id) {
                    $this->actualizarPago($id);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $this->eliminarPago($id);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
                exit;
        }
    }

    private function obtenerPago($id) {
        $pago = $this->pagoService->obtenerPago($id);
        if ($pago) {
            echo json_encode($pago);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Pago no encontrado']);
        }
        exit;
    }

    private function obtenerTodosLosPagos() {
        $pagos = $this->pagoService->obtenerTodosLosPagos();
        echo json_encode($pagos);
        exit;
    }

    private function crearPago() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id_usuario']) || !isset($data['id_casa']) || !isset($data['fecha_pago']) || 
            !isset($data['monto']) || !isset($data['concepto'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = $this->pagoService->crearPago(
            $data['id_usuario'],
            $data['id_casa'],
            $data['fecha_pago'],
            $data['monto'],
            $data['recargo_aplicado'] ?? 0,
            $data['concepto'],
            $data['comprobante_pago'] ?? null
        );

        echo json_encode(['id' => $id, 'mensaje' => 'Pago creado exitosamente']);
        exit;
    }

    private function actualizarPago($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id_usuario']) || !isset($data['id_casa']) || !isset($data['fecha_pago']) || 
            !isset($data['monto']) || !isset($data['concepto'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $resultado = $this->pagoService->actualizarPago(
            $id,
            $data['id_usuario'],
            $data['id_casa'],
            $data['fecha_pago'],
            $data['monto'],
            $data['recargo_aplicado'] ?? 0,
            $data['concepto'],
            $data['comprobante_pago'] ?? null
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Pago actualizado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Pago no encontrado']);
        }
        exit;
    }

    private function eliminarPago($id) {
        $resultado = $this->pagoService->eliminarPago($id);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Pago eliminado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Pago no encontrado']);
        }
        exit;
    }

    public function confirmarPago($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['confirmado_por'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el ID del usuario que confirma']);
            exit;
        }

        $resultado = $this->pagoService->confirmarPago($id, $data['confirmado_por']);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Pago confirmado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Pago no encontrado']);
        }
        exit;
    }

    public function obtenerPagosPorUsuario($id_usuario) {
        $pagos = $this->pagoService->obtenerPagosPorUsuario($id_usuario);
        echo json_encode($pagos);
        exit;
    }

    public function obtenerPagosPorCasa($id_casa) {
        $pagos = $this->pagoService->obtenerPagosPorCasa($id_casa);
        echo json_encode($pagos);
        exit;
    }
} 