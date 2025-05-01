<?php
require_once __DIR__ . '/../../../api/Services/CuotaService.php';
use Api\Services\CuotaService;

$servicio = new CuotaService();

// Eliminar cuota por ID (GET)
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    if ($servicio->eliminarCuota($idEliminar)) {
        $_SESSION['mensaje'] = "🗑️ Cuota ID $idEliminar eliminada correctamente.";
    } else {
        $_SESSION['mensaje'] = "❌ No se pudo eliminar la cuota.";
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Crear nueva cuota (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monto = floatval($_POST['monto']);
    $recargo = floatval($_POST['recargo']);
    $periodo = $_POST['periodo']; // formato YYYY-MM

    [$anio, $mes] = explode('-', $periodo);
    $anio = intval($anio);
    $mes = intval(ltrim($mes, '0')); // "05" → 5

    if ($mes >= 1 && $mes <= 12 && $anio >= 2020) {
        $existe = $servicio->obtenerCuotaPorMesAnio($mes, $anio);
        if ($existe) {
            $_SESSION['mensaje'] = '⚠️ Ya existe una cuota para ese periodo.';
        } else {
            $id = $servicio->crearCuota($monto, $recargo, $mes, $anio);
            $_SESSION['mensaje'] = $id ? '✅ Cuota creada exitosamente.' : '❌ Error al crear la cuota.';
        }
    } else {
        $_SESSION['mensaje'] = '❌ Fecha inválida.';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener todas las cuotas
$cuotas = $servicio->obtenerTodasLasCuotas();
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];
?>

<body class="bg-gray-100 font-sans">
<?php include __DIR__ . '/../../Components/slidebar.php'; ?>

<main class="ml-64 p-8 min-h-screen">
    <div class="max-w-4xl mx-auto space-y-10">

        <!-- Mensaje -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
                <?= htmlspecialchars($_SESSION['mensaje']) ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <!-- Formulario -->
        <section class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📅 Configurar Cuota Mensual</h2>
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Monto</label>
                        <input type="number" name="monto" step="0.01" value="650" required class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recargo</label>
                        <input type="number" name="recargo" step="0.01" value="50" required class="w-full px-4 py-2 border rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mes/Año</label>
                        <input type="month" name="periodo" required class="w-full px-4 py-2 border rounded-md">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        💾 Registrar Cuota
                    </button>
                </div>
            </form>
        </section>

        <!-- Tabla de cuotas -->
        <section class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Cuotas Registradas</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-left text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 font-semibold">#</th>
                            <th class="px-4 py-2 font-semibold">Monto</th>
                            <th class="px-4 py-2 font-semibold">Recargo</th>
                            <th class="px-4 py-2 font-semibold">Mes</th>
                            <th class="px-4 py-2 font-semibold">Año</th>
                            <th class="px-4 py-2 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cuotas as $cuota): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2"><?= $cuota->getId() ?></td>
                                <td class="px-4 py-2">$<?= number_format($cuota->getMonto(), 2) ?></td>
                                <td class="px-4 py-2">$<?= number_format($cuota->getRecargo(), 2) ?></td>
                                <td class="px-4 py-2"><?= $meses[intval($cuota->getMes())] ?? 'Mes inválido' ?></td>
                                <td class="px-4 py-2"><?= $cuota->getAnio() ?></td>
                                <td class="px-4 py-2">
                                    <a href="?eliminar=<?= $cuota->getId() ?>"
                                       onclick="return confirm('¿Eliminar esta cuota?');"
                                       class="text-red-600 hover:underline">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>
</body>
