<?php
require_once __DIR__ . '/../../../api/Core/Conexion.php'; 
use Api\Core\Conexion;

$conn = Conexion::conectar();

$mensaje = '';
$error = '';

// Asignación o reasignación de inquilino
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_casa = $_POST['id_casa'] ?? null;
    $id_inquilino = $_POST['id_inquilino'] ?? null;

    if ($id_casa && $id_inquilino) {
        $queryUpdate = "UPDATE casas SET id_inquilino = :id_inquilino WHERE id = :id_casa";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bindParam(':id_inquilino', $id_inquilino, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id_casa', $id_casa, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            $mensaje = "Inquilino asignado o reasignado correctamente.";
        } else {
            $error = "Error al asignar el inquilino.";
        }
    } else {
        $error = "Selecciona una casa y un inquilino.";
    }
}

// Obtener todas las casas y el nombre del inquilino si ya hay uno
$queryCasas = "
    SELECT c.id, c.numero_casa, u.nombre AS nombre_inquilino
    FROM casas c
    LEFT JOIN usuarios u ON c.id_inquilino = u.id
    ORDER BY c.numero_casa
";
$stmtCasas = $conn->query($queryCasas);
$casas = $stmtCasas->fetchAll(PDO::FETCH_ASSOC);

// Obtener todos los inquilinos
$queryInquilinos = "SELECT id, nombre FROM usuarios WHERE rol = 'inquilino'";
$stmtInquilinos = $conn->query($queryInquilinos);
$inquilinos = $stmtInquilinos->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<?php include __DIR__ . '/../../Components/slidebar.php'; ?>

<main class="ml-64 p-8 bg-gray-100 min-h-screen">
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-indigo-700 mb-6 text-center">
            Asignar o Reasignar Inquilino a Casa
        </h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-success mb-4"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger mb-4"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="form-label text-gray-700">Casa</label>
                <select name="id_casa" required class="form-select border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar casa</option>
                    <?php foreach ($casas as $casa): ?>
                        <option value="<?php echo $casa['id']; ?>">
                            <?php echo htmlspecialchars($casa['numero_casa']); ?>
                            <?php if ($casa['nombre_inquilino']): ?>
                                (Ocupada por <?php echo htmlspecialchars($casa['nombre_inquilino']); ?>)
                            <?php else: ?>
                                (Disponible)
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="form-label text-gray-700">Inquilino</label>
                <select name="id_inquilino" required class="form-select border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar inquilino</option>
                    <?php foreach ($inquilinos as $inquilino): ?>
                        <option value="<?php echo $inquilino['id']; ?>">
                            <?php echo htmlspecialchars($inquilino['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition duration-200">
                    Guardar Asignación
                </button>
            </div>
        </form>
    </div>
</main>
</body>
