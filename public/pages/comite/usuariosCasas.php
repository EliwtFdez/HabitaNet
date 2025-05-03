<?php
require_once __DIR__ . '/../../../api/Core/Conexion.php';
use Api\Core\Conexion;

$conn = Conexion::conectar();

// Paginación
$casas_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) {
    $pagina_actual = 1;
}

// Desasignar inquilino
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['desasignar_id'])) {
    $id_casa = (int)$_POST['desasignar_id'];
    $queryUpdate = "UPDATE casas SET id_inquilino = NULL WHERE id = :id";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bindParam(':id', $id_casa, PDO::PARAM_INT);
    $stmtUpdate->execute();

    // Redirige para evitar reenvío de formulario y mantener paginación
    header("Location: /HabitaNet/public/comite/usuariosCasas?pagina=" . $pagina_actual);
    exit;
}

// Obtener usuarios inquilinos
$queryUsuarios = "SELECT id, nombre, email FROM usuarios WHERE rol = 'inquilino'";
$resultadoUsuarios = $conn->query($queryUsuarios);

// Obtener total de casas
$queryTotalCasas = "SELECT COUNT(*) as total FROM casas";
$resultadoTotalCasas = $conn->query($queryTotalCasas);
$total_casas = $resultadoTotalCasas->fetch(PDO::FETCH_ASSOC)['total'];
$total_paginas = ceil($total_casas / $casas_por_pagina);

if ($pagina_actual > $total_paginas && $total_paginas > 0) {
    $pagina_actual = $total_paginas;
}

$offset = ($pagina_actual - 1) * $casas_por_pagina;

// Obtener casas y sus inquilinos
$queryCasas = "SELECT c.id, c.numero_casa, u.nombre as inquilino_nombre
                    FROM casas c
                    LEFT JOIN usuarios u ON c.id_inquilino = u.id
                    ORDER BY c.numero_casa ASC
                    LIMIT ? OFFSET ?";
$stmtCasas = $conn->prepare($queryCasas);
$stmtCasas->bindValue(1, (int) $casas_por_pagina, PDO::PARAM_INT);
$stmtCasas->bindValue(2, (int) $offset, PDO::PARAM_INT);
$stmtCasas->execute();
$resultadoCasas = $stmtCasas->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<?php include __DIR__ . '/../../Components/slidebar.php'; ?>

<main class="ml-64 p-6">
    <h2 class="text-2xl font-bold mb-6">Gestión de Usuarios y Casas</h2>

    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-xl font-semibold mb-4">Lista de Inquilinos</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Nombre</th>
                        <th class="px-6 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultadoUsuarios && $resultadoUsuarios->rowCount() > 0):
                        while ($usuario = $resultadoUsuarios->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($usuario['email']); ?></td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="3" class="px-6 py-4 border-b text-center text-gray-500">No hay inquilinos registrados.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-xl font-semibold mb-4">Lista de Casas</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Número de Casa</th>
                        <th class="px-6 py-3 border-b-2 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Inquilino</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultadoCasas && count($resultadoCasas) > 0):
                        foreach ($resultadoCasas as $casa): ?>
                    <tr>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($casa['id']); ?></td>
                        <td class="px-6 py-4 border-b"><?php echo htmlspecialchars($casa['numero_casa']); ?></td>
                        <td class="px-6 py-4 border-b">
                            <?php if ($casa['inquilino_nombre']): ?>
                                <div class="flex items-center justify-between">
                                    <span><?php echo htmlspecialchars($casa['inquilino_nombre']); ?></span>
                                    <form method="POST" action="/HabitaNet/public/comite/usuariosCasas?pagina=<?php echo $pagina_actual; ?>" onsubmit="return confirm('¿Estás seguro de quitar al inquilino de esta casa?');">
                                        <input type="hidden" name="desasignar_id" value="<?php echo $casa['id']; ?>">
                                        <button type="submit" class="ml-4 px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">
                                            Quitar
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-500 italic">Sin inquilino</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="3" class="px-6 py-4 border-b text-center text-gray-500">No hay casas registradas.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_paginas > 1): ?>
        <div class="mt-6 flex justify-center items-center space-x-2">
            <?php if ($pagina_actual > 1): ?>
                <a href="?pagina=<?php echo $pagina_actual - 1; ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Anterior
                </a>
            <?php else: ?>
                <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed">Anterior</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?pagina=<?php echo $i; ?>" class="px-4 py-2 rounded <?php echo ($i == $pagina_actual) ? 'bg-indigo-600 text-white' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'; ?> transition">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($pagina_actual < $total_paginas): ?>
                <a href="?pagina=<?php echo $pagina_actual + 1; ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Siguiente
                </a>
            <?php else: ?>
                <span class="px-4 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed">Siguiente</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</main>
</body>

<?php

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