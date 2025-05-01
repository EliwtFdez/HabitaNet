<?php

namespace App\Http\Controllers;

use App\Models\Conexion;
use Exception;
use PDO;

class UsuarioController extends Controller
{
    public function getEstadoCuenta($id_usuario) {
        try {
            $conn = Conexion::conectar();
            
            // Obtener el total pagado en el año actual
            $query = "SELECT COALESCE(SUM(monto), 0) as total_pagado 
                     FROM pagos 
                     WHERE id_usuario = :id_usuario 
                     AND YEAR(fecha_pago) = YEAR(CURRENT_DATE())";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_pagado = $resultado['total_pagado'];
            
            // Calcular el estado de la cuenta
            $estado = "Al corriente";
            if ($total_pagado < 7800) { // 650 * 12 meses
                $estado = "Pendiente";
            }
            
            echo json_encode([
                'estado' => $estado,
                'total_pagado' => $total_pagado
            ]);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener estado de cuenta: ' . $e->getMessage()]);
        }
    }
} 