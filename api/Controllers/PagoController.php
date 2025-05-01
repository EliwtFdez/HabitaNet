<?php
namespace Api\Controllers;

use Api\Core\Conexion;
use Exception;
use PDO;
use DateTime;

class PagoController {
    public function getPagosPorUsuario($id_usuario) {
        try {
            $conn = Conexion::conectar();
            
            $query = "SELECT p.*, u.nombre as confirmado_por,
                     DATE_FORMAT(p.fecha_pago, '%d/%m/%Y') as fecha_pago_formateada,
                     DATE_FORMAT(p.fecha_confirmacion, '%d/%m/%Y %H:%i') as fecha_confirmacion_formateada,
                     CASE 
                        WHEN p.confirmado_por IS NOT NULL THEN 'Confirmado'
                        ELSE 'Pendiente'
                     END as estado
                     FROM pagos p 
                     LEFT JOIN usuarios u ON p.confirmado_por = u.id 
                     WHERE p.id_usuario = :id_usuario 
                     ORDER BY p.fecha_pago DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Asegurar que siempre devolvemos un array
            if (!is_array($pagos)) {
                $pagos = [];
            }
            
            // Formatear los montos
            foreach ($pagos as &$pago) {
                $pago['monto'] = number_format($pago['monto'], 2, '.', ',');
                // Asegurar que todos los campos necesarios existan
                $pago['fecha_pago_formateada'] = $pago['fecha_pago_formateada'] ?? '';
                $pago['fecha_confirmacion_formateada'] = $pago['fecha_confirmacion_formateada'] ?? '';
                $pago['estado'] = $pago['estado'] ?? 'Pendiente';
                $pago['concepto'] = $pago['concepto'] ?? '';
                $pago['comprobante_pago'] = $pago['comprobante_pago'] ?? '';
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true, 
                'data' => $pagos,
                'total' => count($pagos)
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Error al obtener pagos: ' . $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function getEstadoCuenta($id_usuario) {
        try {
            // Establecer headers de respuesta al inicio
            header('Content-Type: application/json');

            if (!is_numeric($id_usuario)) {
                throw new Exception('ID de usuario inválido');
            }

            $conn = Conexion::conectar();
            
            // Verificar que el usuario existe
            $query = "SELECT id FROM usuarios WHERE id = :id_usuario";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            if (!$stmt->fetch()) {
                throw new Exception('El usuario no existe');
            }
            
            // Obtener información de la casa y el usuario
            $query = "SELECT c.numero_casa, u.nombre, 
                     COALESCE((SELECT monto FROM cuotas WHERE mes = MONTH(CURRENT_DATE()) AND anio = YEAR(CURRENT_DATE()) LIMIT 1), 650.00) as monto_mensual
                     FROM casas c 
                     JOIN usuarios u ON c.id_inquilino = u.id 
                     WHERE c.id_inquilino = :id_usuario";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            $casa = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$casa) {
                throw new Exception('Usuario no tiene casa asignada');
            }

            // Obtener pagos del último mes
            $query = "SELECT COALESCE(SUM(monto), 0) as total_pagado 
                     FROM pagos 
                     WHERE id_usuario = :id_usuario 
                     AND fecha_pago >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            $pagos_mes = $stmt->fetch(PDO::FETCH_ASSOC);

            // Obtener total pagado en el año
            $query = "SELECT COALESCE(SUM(monto), 0) as total_pagado_anio 
                     FROM pagos 
                     WHERE id_usuario = :id_usuario 
                     AND YEAR(fecha_pago) = YEAR(CURRENT_DATE())";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            $pagos_anio = $stmt->fetch(PDO::FETCH_ASSOC);

            // Calcular próxima fecha límite (5 de cada mes)
            $fecha_actual = new DateTime();
            $fecha_limite = new DateTime();
            $fecha_limite->setDate($fecha_actual->format('Y'), $fecha_actual->format('m'), 5);
            
            if ($fecha_actual->format('d') > 5) {
                $fecha_limite->modify('+1 month');
            }
            
            $monto_mensual = floatval($casa['monto_mensual']);
            $total_pagado_mes = floatval($pagos_mes['total_pagado']);
            $total_pagado_anio = floatval($pagos_anio['total_pagado_anio']);
            
            $estado_cuenta = [
                'nombre' => $casa['nombre'],
                'numero_casa' => $casa['numero_casa'],
                'monto_mensual' => number_format($monto_mensual, 2, '.', ','),
                'total_pagado_mes' => number_format($total_pagado_mes, 2, '.', ','),
                'total_pagado_anio' => number_format($total_pagado_anio, 2, '.', ','),
                'saldo_pendiente' => number_format($monto_mensual - $total_pagado_mes, 2, '.', ','),
                'estatus' => $total_pagado_mes >= $monto_mensual ? 'Cuota pagada' : 'Cuota pendiente',
                'proxima_fecha_limite' => $fecha_limite->format('d/m/Y')
            ];
            
            echo json_encode(['success' => true, 'data' => $estado_cuenta]);
            
        } catch (Exception $e) {
            error_log("Error en getEstadoCuenta: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => 'Error al obtener estado de cuenta: ' . $e->getMessage()
            ]);
        }
    }

    public function registrarPago() {
        try {
            // Asegurar que no se haya enviado nada antes
            if (ob_get_length()) ob_clean();
            
            // Establecer headers de respuesta
            header('Content-Type: application/json');
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            header("Access-Control-Allow-Headers: Content-Type, Accept");
            header("Access-Control-Allow-Credentials: true");
            
            // Manejar preflight request
            if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                http_response_code(200);
                exit;
            }
            
            // Verificar método
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método no permitido');
            }
            
            // Obtener datos JSON del cuerpo de la petición
            $json = file_get_contents('php://input');
            
            if (empty($json)) {
                throw new Exception('No se recibieron datos');
            }

            $data = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
            }

            // Log de datos recibidos
            error_log("Datos recibidos en registrarPago: " . print_r($data, true));

            // Validación más robusta de datos requeridos
            $campos_requeridos = ['id_usuario', 'monto', 'concepto'];
            $campos_faltantes = array_filter($campos_requeridos, function($campo) use ($data) {
                return !isset($data[$campo]) || empty($data[$campo]);
            });

            if (!empty($campos_faltantes)) {
                throw new Exception('Faltan los siguientes campos requeridos: ' . implode(', ', $campos_faltantes));
            }

            $conn = Conexion::conectar();
            
            // Verificar existencia del usuario
            $query = "SELECT id FROM usuarios WHERE id = :id_usuario";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
            $stmt->execute();
            
            if (!$stmt->fetch()) {
                throw new Exception('El usuario no existe');
            }
            
            // Obtener el id_casa del usuario
            $query = "SELECT id FROM casas WHERE id_inquilino = :id_usuario";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $data['id_usuario'], PDO::PARAM_INT);
            $stmt->execute();
            
            $casa = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$casa) {
                throw new Exception('El usuario no tiene una casa asignada');
            }
            
            $id_usuario = (int)$data['id_usuario'];
            $id_casa = (int)$casa['id'];
            $monto = (float)$data['monto'];
            $concepto = trim($data['concepto']);
            $fecha_pago = $data['fecha_pago'] ?? date('Y-m-d');
            $recargo_aplicado = isset($data['recargo_aplicado']) ? (int)$data['recargo_aplicado'] : 0;
            
            // Validación más estricta de fecha
            $fecha_obj = DateTime::createFromFormat('Y-m-d', $fecha_pago);
            if (!$fecha_obj || $fecha_obj->format('Y-m-d') !== $fecha_pago) {
                throw new Exception('Formato de fecha inválido. Use YYYY-MM-DD');
            }

            // Validar que la fecha no sea futura
            $hoy = new DateTime();
            $hoy->setTime(0, 0, 0);
            $fecha_obj->setTime(0, 0, 0);
            
            if ($fecha_obj > $hoy) {
                error_log("Intento de pago con fecha futura: " . $fecha_pago);
                throw new Exception('La fecha de pago no puede ser futura');
            }
            
            // Verificar si ya existe un pago para este mes
            $query = "SELECT COUNT(*) as total FROM pagos 
                     WHERE id_usuario = :id_usuario 
                     AND MONTH(fecha_pago) = MONTH(:fecha_pago)
                     AND YEAR(fecha_pago) = YEAR(:fecha_pago)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':fecha_pago', $fecha_pago, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['total'] > 0) {
                error_log("Intento de pago duplicado para usuario $id_usuario en fecha $fecha_pago");
                throw new Exception('Ya existe un pago registrado para este mes');
            }

            // Iniciar transacción
            $conn->beginTransaction();

            try {
                // Insertar el pago
                $query = "INSERT INTO pagos (id_usuario, id_casa, monto, concepto, fecha_pago, recargo_aplicado) 
                         VALUES (:id_usuario, :id_casa, :monto, :concepto, :fecha_pago, :recargo_aplicado)";
                
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->bindParam(':id_casa', $id_casa, PDO::PARAM_INT);
                $stmt->bindParam(':monto', $monto, PDO::PARAM_STR);
                $stmt->bindParam(':concepto', $concepto, PDO::PARAM_STR);
                $stmt->bindParam(':fecha_pago', $fecha_pago, PDO::PARAM_STR);
                $stmt->bindParam(':recargo_aplicado', $recargo_aplicado, PDO::PARAM_INT);
                
                if (!$stmt->execute()) {
                    throw new Exception('Error al ejecutar la inserción del pago');
                }

                $id_pago = $conn->lastInsertId();
                
                // Confirmar transacción
                $conn->commit();

                echo json_encode([
                    'success' => true,
                    'mensaje' => 'Pago registrado correctamente',
                    'data' => [
                        'id_pago' => $id_pago,
                        'id_casa' => $id_casa,
                        'monto' => number_format($monto, 2, '.', ','),
                        'fecha_pago' => $fecha_pago
                    ]
                ]);

            } catch (Exception $e) {
                // Revertir transacción en caso de error
                $conn->rollBack();
                throw $e;
            }
            
        } catch (Exception $e) {
            error_log("Error en registrarPago: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Error al registrar pago: ' . $e->getMessage()
            ]);
        }
    }
}
