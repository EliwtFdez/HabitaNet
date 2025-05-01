<?php
require_once __DIR__ . '/../Core/Conexion.php';

use Api\Core\Conexion;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = Conexion::conectar();

        // Validar campos requeridos
        if (!isset($_POST['id_usuario'], $_POST['fecha_pago'], $_POST['monto'], $_POST['concepto'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Faltan campos obligatorios.']);
            exit;
        }

        $id_usuario = $_POST['id_usuario'];
        $fecha_pago = $_POST['fecha_pago'];
        $monto = $_POST['monto'];
        $concepto = $_POST['concepto'];
        $recargo_aplicado = isset($_POST['recargo_aplicado']) && $_POST['recargo_aplicado'] === 'true' ? 1 : 0;

        $mes = date('m', strtotime($fecha_pago));
        $anio = date('Y', strtotime($fecha_pago));

        // Obtener la casa vinculada al usuario
        $stmtCasa = $conn->prepare("SELECT id FROM casas WHERE id_inquilino = ?");
        $stmtCasa->execute([$id_usuario]);
        $casa = $stmtCasa->fetch(PDO::FETCH_ASSOC);

        if (!$casa) {
            http_response_code(404);
            echo json_encode(['error' => 'No se encontró una casa asignada.']);
            exit;
        }

        $id_casa = $casa['id'];

        // Procesar el archivo comprobante
        $comprobante_nombre = null;
        if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
            $nombre_tmp = $_FILES['comprobante']['tmp_name'];
            $nombre_archivo = uniqid() . "_" . basename($_FILES['comprobante']['name']);
            $ruta_destino = __DIR__ . '/../../public/uploads/comprobantes/' . $nombre_archivo;

            if (move_uploaded_file($nombre_tmp, $ruta_destino)) {
                $comprobante_nombre = $nombre_archivo;
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al subir el comprobante.']);
                exit;
            }
        }

        // Insertar el pago
        $stmt = $conn->prepare("
            INSERT INTO pagos (
                id_usuario, id_casa, fecha_pago, monto, recargo_aplicado,
                concepto, comprobante_pago
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $id_usuario,
            $id_casa,
            $fecha_pago,
            $monto,
            $recargo_aplicado,
            $concepto,
            $comprobante_nombre
        ]);

        echo json_encode(['mensaje' => 'Pago registrado exitosamente. Pendiente de confirmación.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al procesar el pago: ' . $e->getMessage()]);
    }
}
