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
    header("Location: ?pagina=" . $pagina_actual);
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
    
    <!-- Lista de Inquilinos -->
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

    <!-- Lista de Casas -->
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
                                    <form method="POST" action="?pagina=<?php echo $pagina_actual; ?>" onsubmit="return confirm('¿Estás seguro de quitar al inquilino de esta casa?');">
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

        <!-- Paginación -->
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
