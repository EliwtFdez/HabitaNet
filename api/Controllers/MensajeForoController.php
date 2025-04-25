<?php
namespace Api\Controllers;

require_once __DIR__ . '/../Services/MensajeForoService.php';

class MensajeForoController {
    private $mensajeService;

    public function __construct() {
        $this->mensajeService = new \Api\Services\MensajeForoService();
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->obtenerMensaje($id);
                } else {
                    $this->obtenerTodosLosMensajes();
                }
                break;
            case 'POST':
                $this->crearMensaje();
                break;
            case 'PUT':
                if ($id) {
                    $this->actualizarMensaje($id);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $this->eliminarMensaje($id);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
                exit;
        }
    }

    private function obtenerMensaje($id) {
        $mensaje = $this->mensajeService->obtenerMensaje($id);
        if ($mensaje) {
            echo json_encode($mensaje);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Mensaje no encontrado']);
        }
        exit;
    }

    private function obtenerTodosLosMensajes() {
        $mensajes = $this->mensajeService->obtenerTodosLosMensajes();
        echo json_encode($mensajes);
        exit;
    }

    private function crearMensaje() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id_usuario']) || !isset($data['mensaje'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos requeridos']);
            exit;
        }

        $id = $this->mensajeService->crearMensaje(
            $data['id_usuario'],
            $data['mensaje']
        );

        echo json_encode(['id' => $id, 'mensaje' => 'Mensaje creado exitosamente']);
        exit;
    }

    private function actualizarMensaje($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['mensaje'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el mensaje']);
            exit;
        }

        $resultado = $this->mensajeService->actualizarMensaje(
            $id,
            $data['mensaje']
        );

        if ($resultado) {
            echo json_encode(['mensaje' => 'Mensaje actualizado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Mensaje no encontrado']);
        }
        exit;
    }

    private function eliminarMensaje($id) {
        $resultado = $this->mensajeService->eliminarMensaje($id);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Mensaje eliminado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Mensaje no encontrado']);
        }
        exit;
    }

    public function obtenerMensajesPorUsuario($id_usuario) {
        $mensajes = $this->mensajeService->obtenerMensajesPorUsuario($id_usuario);
        echo json_encode($mensajes);
        exit;
    }

    public function ocultarMensaje($id) {
        $resultado = $this->mensajeService->ocultarMensaje($id);
        if ($resultado) {
            echo json_encode(['mensaje' => 'Mensaje ocultado exitosamente']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Mensaje no encontrado']);
        }
        exit;
    }

    public function obtenerMensajesRecientes($limite = 10) {
        $mensajes = $this->mensajeService->obtenerMensajesRecientes($limite);
        echo json_encode($mensajes);
        exit;
    }
} 