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
        
        // Validación de campos requeridos y tipos
        if (!isset($data['monto']) || !is_numeric($data['monto']) || $data['monto'] < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'El monto es requerido y debe ser un número positivo.']);
            exit;
        }
        if (!isset($data['mes']) || !is_numeric($data['mes']) || $data['mes'] < 1 || $data['mes'] > 12 || floor($data['mes']) != $data['mes']) {
            http_response_code(400);
            echo json_encode(['error' => 'El mes es requerido y debe ser un entero entre 1 y 12.']);
            exit;
        }
        if (!isset($data['anio']) || !is_numeric($data['anio']) || $data['anio'] < 2020 || floor($data['anio']) != $data['anio']) {
            http_response_code(400);
            echo json_encode(['error' => 'El año es requerido y debe ser un entero mayor o igual a 2020.']);
            exit;
        }
        // Validación opcional para recargo
        $recargo = $data['recargo'] ?? 50.00; // Valor por defecto si no se proporciona
        if (!is_numeric($recargo) || $recargo < 0) {
             http_response_code(400);
             echo json_encode(['error' => 'El recargo debe ser un número positivo.']);
             exit;
        }


        try {
            $id = $this->cuotaService->crearCuota(
                $data['monto'],
                $recargo,
                (int)$data['mes'], // Asegurar que se pasa como entero
                (int)$data['anio']  // Asegurar que se pasa como entero
            );

            http_response_code(201);
            echo json_encode(['id' => $id, 'mensaje' => 'Cuota creada exitosamente']);
        } catch (\InvalidArgumentException $e) {
             http_response_code(400);
             echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            // Log general error $e->getMessage()
            http_response_code(500);
            echo json_encode(['error' => 'Error interno al crear la cuota.']);
        }
        exit;
    }

    private function actualizarCuota($id) {
         if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de cuota inválido.']);
            exit;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        
         // Validación de campos requeridos y tipos
        if (!isset($data['monto']) || !is_numeric($data['monto']) || $data['monto'] < 0) {
            http_response_code(400);
            echo json_encode(['error' => 'El monto es requerido y debe ser un número positivo.']);
            exit;
        }
        if (!isset($data['mes']) || !is_numeric($data['mes']) || $data['mes'] < 1 || $data['mes'] > 12 || floor($data['mes']) != $data['mes']) {
            http_response_code(400);
            echo json_encode(['error' => 'El mes es requerido y debe ser un entero entre 1 y 12.']);
            exit;
        }
        if (!isset($data['anio']) || !is_numeric($data['anio']) || $data['anio'] < 2020 || floor($data['anio']) != $data['anio']) {
            http_response_code(400);
            echo json_encode(['error' => 'El año es requerido y debe ser un entero mayor o igual a 2020.']);
            exit;
        }
        // Validación opcional para recargo
        $recargo = $data['recargo'] ?? 50.00; // Valor por defecto si no se proporciona
        if (!is_numeric($recargo) || $recargo < 0) {
             http_response_code(400);
             echo json_encode(['error' => 'El recargo debe ser un número positivo.']);
             exit;
        }

        try {
            $resultado = $this->cuotaService->actualizarCuota(
                (int)$id,
                $data['monto'],
                $recargo,
                (int)$data['mes'], // Asegurar que se pasa como entero
                (int)$data['anio']  // Asegurar que se pasa como entero
            );

            if ($resultado) {
                echo json_encode(['mensaje' => 'Cuota actualizada exitosamente']);
            } else {
                // Podría ser que la cuota no exista o que la validación del servicio falle (aunque ya validamos aquí)
                http_response_code(404); // O 400 dependiendo de la causa exacta
                echo json_encode(['error' => 'No se pudo actualizar la cuota. Verifique el ID o los datos.']);
            }
        } catch (\InvalidArgumentException $e) {
             http_response_code(400);
             echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            // Log general error $e->getMessage()
            http_response_code(500);
            echo json_encode(['error' => 'Error interno al actualizar la cuota.']);
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