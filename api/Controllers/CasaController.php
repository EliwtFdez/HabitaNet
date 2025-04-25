<?php
namespace Api\Controllers;

require_once __DIR__ . '/../Services/CasaService.php';

class CasaController {
    private $casaService;

    public function __construct() {
        $this->casaService = new \Api\Services\CasaService();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id === 'disponibles') {
                    $this->obtenerCasasDisponibles();
                } elseif ($id) {
                    $this->obtenerCasa($id);
                } else {
                    $this->obtenerTodasLasCasas();
                }
                break;
            case 'POST':
                $this->crearCasa();
                break;
            case 'PUT':
                $this->actualizarCasa($id);
                break;
            case 'DELETE':
                $this->eliminarCasa($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
                exit;
        }
    }

    private function obtenerCasa($id) {
        $casa = $this->casaService->obtenerCasa($id);
        if ($casa) {
            echo json_encode([
                'id' => $casa->getId(),
                'numero_casa' => $casa->getNumeroCasa(),
                'id_inquilino' => $casa->getIdInquilino()
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Casa no encontrada']);
        }
        exit;
    }

    private function obtenerTodasLasCasas() {
        $casas = $this->casaService->obtenerTodasLasCasas();
        $resultado = [];
        foreach ($casas as $casa) {
            $resultado[] = [
                'id' => $casa->getId(),
                'numero_casa' => $casa->getNumeroCasa(),
                'id_inquilino' => $casa->getIdInquilino()
            ];
        }
        echo json_encode($resultado);
        exit;
    }

    private function obtenerCasasDisponibles() {
        $casas = $this->casaService->obtenerCasasDisponibles();
        $resultado = [];
        foreach ($casas as $casa) {
            $resultado[] = [
                'id' => $casa->getId(),
                'numero_casa' => $casa->getNumeroCasa(),
                'id_inquilino' => $casa->getIdInquilino()
            ];
        }
        echo json_encode($resultado);
        exit;
    }

    private function crearCasa() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['numero_casa'])) {
            http_response_code(400);
            echo json_encode(['error' => 'El número de casa es requerido']);
            exit;
        }

        $id = $this->casaService->crearCasa(
            $data['numero_casa'],
            $data['id_inquilino'] ?? null
        );

        http_response_code(201);
        echo json_encode(['id' => $id, 'mensaje' => 'Casa creada exitosamente']);
        exit;
    }

    private function actualizarCasa($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['numero_casa'])) {
            http_response_code(400);
            echo json_encode(['error' => 'El número de casa es requerido']);
            exit;
        }

        $resultado = $this->casaService->actualizarCasa(
            $id,
            $data['numero_casa'],
            $data['id_inquilino'] ?? null
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Casa actualizada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Casa no encontrada']);
        }
        exit;
    }

    private function eliminarCasa($id) {
        $resultado = $this->casaService->eliminarCasa($id);
        
        if ($resultado) {
            echo json_encode(['mensaje' => 'Casa eliminada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Casa no encontrada']);
        }
        exit;
    }
} 