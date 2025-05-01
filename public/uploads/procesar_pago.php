<?php
// Asegúrate que las clases estén disponibles (si usas Composer)
require_once __DIR__ . '/../../vendor/autoload.php';

// Iniciar sesión para obtener el id_usuario
session_start();

// Establecer encabezado JSON para todas las respuestas
header('Content-Type: application/json');

// Permitir solo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// --- Validar datos recibidos ---
// Obtener id_usuario de la sesión
$id_usuario = $_SESSION['id_usuario'] ?? null;
if (!$id_usuario) {
    http_response_code(401); // No autorizado (o 400 Bad Request)
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

// Obtener otros datos del POST
$monto = $_POST['monto'] ?? null;
$fecha_pago = $_POST['fecha_pago'] ?? null;
$concepto = $_POST['concepto'] ?? null;
$file = $_FILES['comprobante'] ?? null;

// Validar datos obligatorios (excepto id_casa que se buscará)
if (!$monto || !$fecha_pago || !$concepto || !$file) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan datos obligatorios (monto, fecha, concepto o archivo)']);
    exit;
}

// --- Validar archivo ---
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    // Podrías dar mensajes más específicos basados en $file['error']
    echo json_encode(['error' => 'Error al subir el archivo']);
    exit;
}

if ($file['type'] !== 'application/pdf') {
    http_response_code(400);
    echo json_encode(['error' => 'El archivo debe ser un PDF']);
    exit;
}

if ($file['size'] > 5 * 1024 * 1024) { // 5MB
    http_response_code(400);
    echo json_encode(['error' => 'El archivo excede el límite de 5MB']);
    exit;
}

// --- Mover el archivo ---
$uploadDir = __DIR__ . '/comprobantes/'; // Directorio dentro de 'uploads'
$nombreArchivo = uniqid('comprobante_' . $id_usuario . '_') . '.pdf';
$rutaDestino = $uploadDir . $nombreArchivo;

// Crear carpeta si no existe
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0775, true)) {
        http_response_code(500);
        echo json_encode(['error' => 'No se pudo crear el directorio de subida']);
        exit;
    }
}

if (!move_uploaded_file($file['tmp_name'], $rutaDestino)) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar el comprobante']);
    exit;
}

// --- Insertar en la base de datos ---
try {
    // Usar la conexión estática correcta
    $conn = \Api\Core\Conexion::conectar();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Asegurar que PDO lance excepciones

    // Buscar id_casa asociado al id_usuario (inquilino)
    $stmtCasa = $conn->prepare("SELECT id FROM casas WHERE id_inquilino = :id_usuario");
    $stmtCasa->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmtCasa->execute();
    $id_casa = $stmtCasa->fetchColumn();

    if (!$id_casa) {
        // Si no se encuentra la casa, eliminar el archivo subido para no dejar basura
        if (file_exists($rutaDestino)) {
            unlink($rutaDestino);
        }
        throw new Exception('No se encontró la casa asociada al usuario');
    }

    // Preparar inserción en pagos
    // Añadimos recargo_aplicado (asumiendo que existe en tu tabla pagos)
    $recargo_aplicado = 0; // Valor por defecto, puedes calcularlo si es necesario

    $stmt = $conn->prepare("
        INSERT INTO pagos (id_usuario, id_casa, fecha_pago, monto, concepto, comprobante_pago, recargo_aplicado)
        VALUES (:id_usuario, :id_casa, :fecha_pago, :monto, :concepto, :comprobante, :recargo)
    ");

    // Vincular parámetros usando PDO
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':id_casa', $id_casa, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_pago', $fecha_pago); // PDO suele manejar bien las fechas como string
    $stmt->bindParam(':monto', $monto); // PDO maneja números como string si es necesario
    $stmt->bindParam(':concepto', $concepto, PDO::PARAM_STR);
    $stmt->bindParam(':comprobante', $nombreArchivo, PDO::PARAM_STR);
    $stmt->bindParam(':recargo', $recargo_aplicado, PDO::PARAM_INT); // O PDO::PARAM_STR si es decimal

    $stmt->execute();

    echo json_encode(['mensaje' => 'Pago registrado exitosamente. Pendiente de confirmación.']);

} catch (PDOException $e) {
    // Error específico de PDO
    http_response_code(500);
    // Eliminar archivo si la inserción falló
    if (file_exists($rutaDestino)) {
        unlink($rutaDestino);
    }
    // No mostrar $e->getMessage() directamente en producción por seguridad
    error_log("Error PDO en procesar_pago: " . $e->getMessage()); // Loguear el error real
    echo json_encode(['error' => 'Error al conectar o guardar en la base de datos.']);

} catch (Exception $e) {
    // Otros errores (ej. casa no encontrada)
    http_response_code(500);
     // Asegurarse que el archivo se borre si ya se había movido pero hubo otro error
    if (isset($rutaDestino) && file_exists($rutaDestino)) {
        unlink($rutaDestino);
    }
    error_log("Error general en procesar_pago: " . $e->getMessage()); // Loguear el error real
    echo json_encode(['error' => $e->getMessage()]); // Puedes mostrar este si es seguro (como 'casa no encontrada')
} finally {
    // Cerrar conexión PDO (aunque no es estrictamente necesario con PDO)
    $conn = null;
}
?>
