<?php
session_start();
require_once __DIR__ . '/../../conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /login.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$monto = 650.00;
$recargo = 0.00;
$concepto = "Cuota mensual";
$confirmado = false;
$comprobante_nombre = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha_pago = $_POST['fecha_pago'];

    // Calcular si aplica recargo (si es después del día 5)
    $dia_pago = (int)date('j', strtotime($fecha_pago));
    $recargo_aplicado = $dia_pago > 5;

    if ($recargo_aplicado) {
        $recargo = 50.00;
        $monto += $recargo;
    }

    // Manejo del archivo PDF
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
        $archivo_tmp = $_FILES['comprobante']['tmp_name'];
        $nombre_archivo = basename($_FILES['comprobante']['name']);
        $ruta_destino = __DIR__ . '/../../comprobantes/' . $nombre_archivo;

        // Validar extensión
        $ext = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            echo "El comprobante debe ser un archivo PDF.";
            exit;
        }

        // Mover archivo
        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            $comprobante_nombre = $nombre_archivo;
        } else {
            echo "Error al subir el comprobante.";
            exit;
        }
    } else {
        echo "No se recibió un comprobante válido.";
        exit;
    }

    // Obtener ID de casa
    $sql_casa = "SELECT id FROM casas WHERE id_inquilino = ?";
    $stmt = $conn->prepare($sql_casa);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    $id_casa = $fila['id'] ?? null;

    if (!$id_casa) {
        echo "Error: No se encontró la casa asociada.";
        exit;
    }

    // Insertar el pago
    $sql = "INSERT INTO pagos (id_usuario, id_casa, fecha_pago, monto, recargo_aplicado, concepto, comprobante_pago)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisddss", $id_usuario, $id_casa, $fecha_pago, $monto, $recargo_aplicado, $concepto, $comprobante_nombre);

    if ($stmt->execute()) {
        header("Location: /pages/pagos/index.php?exito=1");
        exit;
    } else {
        echo "Error al guardar el pago: " . $stmt->error;
    }
}
?>
