<?php


// Obtener todos los usuarios con rol de inquilino
$queryUsuarios = "SELECT id, nombre, email FROM usuarios WHERE rol = 'inquilino'";
$resultadoUsuarios = $conn->query($queryUsuarios);

// Obtener todas las casas con información de inquilinos
$queryCasas = "SELECT c.id, c.numero_casa, u.nombre as inquilino_nombre 
               FROM casas c 
               LEFT JOIN usuarios u ON c.id_inquilino = u.id";
$resultadoCasas = $conn->query($queryCasas);
?>

<body>
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-6">
        <h2 class="text-2xl font-bold mb-6">Gestión de Usuarios y Casas</h2>
        
        <!-- Sección de Usuarios -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-semibold mb-4">Lista de Inquilinos</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($usuario = $resultadoUsuarios->fetch_assoc()): ?>
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($usuario['email']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección de Casas -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">Lista de Casas</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Número de Casa</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Inquilino</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($casa = $resultadoCasas->fetch_assoc()): ?>
                        <tr>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($casa['id']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($casa['numero_casa']); ?></td>
                            <td class="px-6 py-4 border-b border-gray-200"><?php echo htmlspecialchars($casa['inquilino_nombre'] ?? 'Sin inquilino'); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body> 