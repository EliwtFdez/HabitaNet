<?php
namespace Api\Controllers;

require_once __DIR__ . '/../Services/CuotaService.php';

class CuotaController {
    private $cuotaService;

    public function __construct() {
        $this->cuotaService = new \Api\Services\CuotaService();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->obtenerCuota($id);
                } else {
                    $this->obtenerTodasLasCuotas();
                }
                break;
            case 'POST':
                $this->crearCuota();
                break;
            case 'PUT':
                $this->actualizarCuota($id);
                break;
            case 'DELETE':
                $this->eliminarCuota($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
                exit;
        }
    }

    private function obtenerCuota($id) {
        $cuota = $this->cuotaService->obtenerCuota($id);
        if ($cuota) {
            echo json_encode([
                'id' => $cuota->getId(),
                'monto' => $cuota->getMonto(),
                'recargo' => $cuota->getRecargo(),
                'mes' => $cuota->getMes(),
                'anio' => $cuota->getAnio()
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cuota no encontrada']);
        }
        exit;
    }

    private function obtenerTodasLasCuotas() {
        $cuotas = $this->cuotaService->obtenerTodasLasCuotas();
        $resultado = [];
        foreach ($cuotas as $cuota) {
            $resultado[] = [
                'id' => $cuota->getId(),
                'monto' => $cuota->getMonto(),
                'recargo' => $cuota->getRecargo(),
                'mes' => $cuota->getMes(),
                'anio' => $cuota->getAnio()
            ];
        }
        echo json_encode($resultado);
        exit;
    }

    private function crearCuota() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['monto']) || !isset($data['mes']) || !isset($data['anio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'El monto, mes y año son requeridos']);
            exit;
        }

        $id = $this->cuotaService->crearCuota(
            $data['monto'],
            $data['recargo'] ?? 50.00,
            $data['mes'],
            $data['anio']
        );

        http_response_code(201);
        echo json_encode(['id' => $id, 'mensaje' => 'Cuota creada exitosamente']);
        exit;
    }

    private function actualizarCuota($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['monto']) || !isset($data['mes']) || !isset($data['anio'])) {
            http_response_code(400);
            echo json_encode(['error' => 'El monto, mes y año son requeridos']);
            exit;
        }

        $resultado = $this->cuotaService->actualizarCuota(
            $id,
            $data['monto'],
            $data['recargo'] ?? 50.00,
            $data['mes'],
            $data['anio']
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Cuota actualizada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cuota no encontrada']);
        }
        exit;
    }

    private function eliminarCuota($id) {
        $resultado = $this->cuotaService->eliminarCuota($id);
        
        if ($resultado) {
            echo json_encode(['mensaje' => 'Cuota eliminada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Cuota no encontrada']);
        }
        exit;
    }
} 