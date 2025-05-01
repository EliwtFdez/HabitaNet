<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../../api/Services/PagoService.php';
require_once __DIR__ . '/../../../api/Services/ConfirmarService.php';

// Verificar si el usuario está autenticado y es comité
if (!isLoggedIn() || !isComite()) {
    header('Location: /HabitaNet/public/login');
    exit;
}

use Api\Services\PagoService;
use Api\Services\ConfirmarService;

$pagoService = new PagoService();
$pagos = $pagoService->obtenerTodosLosPagos();
?>

<body class="bg-gray-100 font-sans">
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-8 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-10">
            <!-- Mensaje -->
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                    <?= htmlspecialchars($_SESSION['mensaje']) ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <!-- Filtros -->
            <section class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">🔍 Filtros</h2>
                <div class="flex gap-4">
                    <select id="filtroEstado" class="px-4 py-2 border rounded-md">
                        <option value="todos">Todos los estados</option>
                        <option value="pendiente">Pendientes</option>
                        <option value="confirmado">Confirmados</option>
                    </select>
                    <input type="date" id="filtroFecha" class="px-4 py-2 border rounded-md">
                </div>
            </section>

            <!-- Tabla de Pagos -->
            <section class="bg-white rounded-xl shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Pagos Registrados</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-left text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 font-semibold">#</th>
                                <th class="px-4 py-2 font-semibold">Usuario</th>
                                <th class="px-4 py-2 font-semibold">Fecha</th>
                                <th class="px-4 py-2 font-semibold">Monto</th>
                                <th class="px-4 py-2 font-semibold">Concepto</th>
                                <th class="px-4 py-2 font-semibold">Estado</th>
                                <th class="px-4 py-2 font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaPagos">
                            <?php foreach ($pagos as $pago): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $pago->getId() ?></td>
                                    <td class="px-4 py-2"><?= $pago->getIdUsuario() ?></td>
                                    <td class="px-4 py-2"><?= date('d/m/Y', strtotime($pago->getFechaPago())) ?></td>
                                    <td class="px-4 py-2">$<?= number_format($pago->getMonto(), 2) ?></td>
                                    <td class="px-4 py-2"><?= $pago->getConcepto() ?></td>
                                    <td class="px-4 py-2">
                                        <?php if ($pago->getConfirmadoPor()): ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmado
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2">
                                        <?php if (!$pago->getConfirmadoPor()): ?>
                                            <button onclick="confirmarPago(<?= $pago->getId() ?>)" 
                                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                                ✅ Confirmar
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <script>
        // Filtros
        document.getElementById('filtroEstado').addEventListener('change', filtrarPagos);
        document.getElementById('filtroFecha').addEventListener('change', filtrarPagos);

        function filtrarPagos() {
            const estado = document.getElementById('filtroEstado').value;
            const fecha = document.getElementById('filtroFecha').value;
            const filas = document.querySelectorAll('#tablaPagos tr');
            
            filas.forEach(fila => {
                const estadoRow = fila.querySelector('td:nth-child(6)').textContent.trim().toLowerCase();
                const fechaRow = fila.querySelector('td:nth-child(3)').textContent.trim();
                
                let mostrar = true;
                
                if (estado !== 'todos' && estadoRow !== estado) {
                    mostrar = false;
                }
                
                if (fecha && fechaRow !== fecha) {
                    mostrar = false;
                }
                
                fila.style.display = mostrar ? '' : 'none';
            });
        }

        function confirmarPago(id) {
            if (confirm('¿Estás seguro de que deseas confirmar este pago?')) {
                fetch(`/HabitaNet/public/api/pagos/${id}/confirmar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Pago confirmado exitosamente');
                        location.reload();
                    } else {
                        alert('Error al confirmar el pago: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Error al procesar la solicitud');
                });
            }
        }
    </script>
</body>
</html>

