<?php
namespace Api\Controllers;

require_once __DIR__ . '/../Services/SolicitudServicioService.php';

class SolicitudServicioController {
    private $solicitudService;

    public function __construct() {
        $this->solicitudService = new \Api\Services\SolicitudServicioService();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->obtenerSolicitud($id);
                } else {
                    $this->obtenerTodasLasSolicitudes();
                }
                break;
            case 'POST':
                $this->crearSolicitud();
                break;
            case 'PUT':
                if ($id) {
                    $this->actualizarSolicitud($id);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $this->eliminarSolicitud($id);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
                exit;
        }
    }

    private function obtenerSolicitud($id) {
        $solicitud = $this->solicitudService->obtenerSolicitud($id);
        if ($solicitud) {
            echo json_encode($solicitud);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Solicitud no encontrada']);
        }
        exit;
    }

    private function obtenerTodasLasSolicitudes() {
        $solicitudes = $this->solicitudService->obtenerTodasLasSolicitudes();
        echo json_encode($solicitudes);
        exit;
    }

    private function crearSolicitud() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id_usuario']) || !isset($data['tipo']) || !isset($data['fecha_solicitud']) || 
            !isset($data['comentario'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = $this->solicitudService->crearSolicitud(
            $data['id_usuario'],
            $data['tipo'],
            $data['fecha_solicitud'],
            $data['comentario']
        );

        echo json_encode(['id' => $id, 'mensaje' => 'Solicitud creada exitosamente']);
        exit;
    }

    private function actualizarSolicitud($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['tipo']) || !isset($data['comentario'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $resultado = $this->solicitudService->actualizarSolicitud(
            $id,
            $data['tipo'],
            $data['comentario']
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Solicitud actualizada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Solicitud no encontrada']);
        }
        exit;
    }

    private function eliminarSolicitud($id) {
        $resultado = $this->solicitudService->eliminarSolicitud($id);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Solicitud eliminada exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Solicitud no encontrada']);
        }
        exit;
    }

    public function obtenerSolicitudesPorUsuario($id_usuario) {
        $solicitudes = $this->solicitudService->obtenerSolicitudesPorUsuario($id_usuario);
        echo json_encode($solicitudes);
        exit;
    }

    public function actualizarEstatus($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['estatus'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el estatus']);
            exit;
        }

        $resultado = $this->solicitudService->actualizarEstatus(
            $id,
            $data['estatus'],
            $data['respuesta'] ?? null
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Estatus actualizado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Solicitud no encontrada']);
        }
        exit;
    }

    public function obtenerSolicitudesPorEstatus($estatus) {
        $solicitudes = $this->solicitudService->obtenerSolicitudesPorEstatus($estatus);
        echo json_encode($solicitudes);
        exit;
    }

    public function obtenerSolicitudesPorTipo($tipo) {
        $solicitudes = $this->solicitudService->obtenerSolicitudesPorTipo($tipo);
        echo json_encode($solicitudes);
        exit;
    }
} 