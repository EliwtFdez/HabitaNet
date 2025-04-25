<?php
namespace Api\Controllers;

require_once __DIR__ . '/../Services/EgresoService.php';

class EgresoController {
    private $egresoService;

    public function __construct() {
        $this->egresoService = new \Api\Services\EgresoService();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->obtenerEgreso($id);
                } else {
                    $this->obtenerTodosLosEgresos();
                }
                break;
            case 'POST':
                $this->crearEgreso();
                break;
            case 'PUT':
                if ($id) {
                    $this->actualizarEgreso($id);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $this->eliminarEgreso($id);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
                exit;
        }
    }

    private function obtenerEgreso($id) {
        $egreso = $this->egresoService->obtenerEgreso($id);
        if ($egreso) {
            echo json_encode($egreso);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Egreso no encontrado']);
        }
        exit;
    }

    private function obtenerTodosLosEgresos() {
        $egresos = $this->egresoService->obtenerTodosLosEgresos();
        echo json_encode($egresos);
        exit;
    }

    private function crearEgreso() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['fecha']) || !isset($data['monto']) || !isset($data['motivo']) || 
            !isset($data['pagado_a']) || !isset($data['registrado_por'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = $this->egresoService->crearEgreso(
            $data['fecha'],
            $data['monto'],
            $data['motivo'],
            $data['pagado_a'],
            $data['registrado_por']
        );

        echo json_encode(['id' => $id, 'mensaje' => 'Egreso creado exitosamente']);
        exit;
    }

    private function actualizarEgreso($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['fecha']) || !isset($data['monto']) || !isset($data['motivo']) || 
            !isset($data['pagado_a'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $resultado = $this->egresoService->actualizarEgreso(
            $id,
            $data['fecha'],
            $data['monto'],
            $data['motivo'],
            $data['pagado_a']
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Egreso actualizado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Egreso no encontrado']);
        }
        exit;
    }

    private function eliminarEgreso($id) {
        $resultado = $this->egresoService->eliminarEgreso($id);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Egreso eliminado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Egreso no encontrado']);
        }
        exit;
    }

    public function obtenerEgresosPorUsuario($id_usuario) {
        $egresos = $this->egresoService->obtenerEgresosPorUsuario($id_usuario);
        echo json_encode($egresos);
        exit;
    }

    public function obtenerEgresosPorFecha($fecha_inicio, $fecha_fin) {
        $egresos = $this->egresoService->obtenerEgresosPorFecha($fecha_inicio, $fecha_fin);
        echo json_encode($egresos);
        exit;
    }
} 