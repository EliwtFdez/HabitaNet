<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../../api/Services/CuotaService.php';
require_once __DIR__ . '/../../../api/Services/PagoService.php';

// Verificar si el usuario está autenticado
if (!isLoggedIn()) {
    header('Location: /HabitaNet/public/login');
    exit;
}

// Verificar si el usuario es inquilino
if (!isInquilino()) {
    header('Location: /HabitaNet/public/dashboard');
    exit;
}

// Obtener el ID del usuario y su casa
require_once __DIR__ . '/../../../api/Core/Conexion.php';
use Api\Core\Conexion;
use Api\Services\CuotaService;
use Api\Services\PagoService;

$conn = Conexion::conectar();
$id_usuario = $_SESSION['user_id'];
$cuotaService = new CuotaService();
$pagoService = new PagoService();

// Obtener la casa del inquilino
$query = "SELECT c.id as id_casa FROM casas c WHERE c.id_inquilino = :id_usuario";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$casa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$casa) {
    $_SESSION['mensaje'] = "❌ No tienes una casa asignada.";
    header('Location: /HabitaNet/public/dashboard');
    exit;
}

$id_casa = $casa['id_casa'];

// Obtener la cuota actual
$mes_actual = date('n');
$anio_actual = date('Y');
$cuota_actual = $cuotaService->obtenerCuotaPorMesAnio($mes_actual, $anio_actual);

// Si no hay cuota configurada para el mes actual, usar una cuota por defecto
if (!$cuota_actual) {
    $monto_default = 650.00; // Monto por defecto
    $recargo_default = 100.00; // Recargo por defecto
    try {
        // Intentar crear la cuota para el mes actual
        $id_cuota = $cuotaService->crearCuota($monto_default, $recargo_default, $mes_actual, $anio_actual);
        $cuota_actual = $cuotaService->obtenerCuota($id_cuota);
    } catch (Exception $e) {
        // Si falla la creación, crear un objeto cuota temporal
        $cuota_actual = new \Api\Models\Cuota(0, $monto_default, $recargo_default, $mes_actual, $anio_actual);
    }
}

// Verificar si ya pagó la cuota actual
$ya_pago = false;
if ($cuota_actual) {
    $pagos = $pagoService->obtenerPagosPorUsuario($id_usuario);
    foreach ($pagos as $pago) {
        if ($pago->getFechaPago() && date('n', strtotime($pago->getFechaPago())) == $mes_actual && 
            date('Y', strtotime($pago->getFechaPago())) == $anio_actual &&
            $pago->getConfirmadoPor() !== null) { // Solo considerar pagos confirmados
            $ya_pago = true;
            break;
        }
    }
}

// Calcular recargo
$fecha_limite = new DateTime(date('Y-m-05')); // Cambiar al día 5 de cada mes
$hoy = new DateTime();
$tiene_recargo = $hoy > $fecha_limite;
$monto_total = $cuota_actual ? ($tiene_recargo ? $cuota_actual->getMonto() + $cuota_actual->getRecargo() : $cuota_actual->getMonto()) : 0;

include __DIR__ . '/../../Components/slidebar.php';
?>

<main class="ml-64 p-6 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <!-- Mensaje de feedback -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="p-4 mb-6 bg-green-100 text-green-800 rounded-lg border border-green-300">
                <?= htmlspecialchars($_SESSION['mensaje']) ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <!-- Encabezado con información de pago -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg mb-6 p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Pago de Cuota Mensual</h2>
                    <p class="mt-1 text-blue-100">Realiza tu pago mensual de manera fácil y segura</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-100">Monto a pagar:</p>
                    <p class="text-3xl font-bold" id="monto-pagar-header">$<?= number_format($monto_total, 2) ?> MXN</p>
                    <?php if ($tiene_recargo): ?>
                        <p class="text-sm text-red-300">Incluye recargo por pago tardío</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Estado de cuenta resumen -->
        <div class="bg-white rounded-lg shadow-md p-5 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Estado de cuenta</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-500">Próxima fecha límite</p>
                    <p class="font-bold text-blue-600"><?= $fecha_limite->format('d/m/Y') ?></p>
                </div>
                <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
                    <p class="text-sm text-gray-500">Total pagado (Año)</p>
                    <p class="font-bold text-purple-600" id="total-pagado">$0.00</p>
                </div>
            </div>
        </div>

        <?php if (!$ya_pago): ?>
        <!-- Formulario para nuevo pago -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                Realizar nuevo pago
            </h3>

            <form id="form-pago" class="space-y-4" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">Monto a pagar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="text" id="monto" name="monto" value="<?= number_format($monto_total, 2) ?>" readonly
                            class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-gray-50">
                            <?php if ($tiene_recargo): ?>
                            <p class="mt-1 text-sm text-red-600">Incluye recargo por pago tardío</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label for="fecha_pago" class="block text-sm font-medium text-gray-700 mb-1">Fecha de pago</label>
                        <input type="date" id="fecha_pago" name="fecha_pago" 
                               value="<?= date('Y-m-d') ?>" 
                               max="<?= date('Y-m-d') ?>"
                               required
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        <p class="mt-1 text-sm text-gray-500">No puede ser posterior a hoy</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="concepto" class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                        <select id="concepto" name="concepto" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="">Seleccione un concepto</option>
                            <option value="Cuota mensual">Cuota mensual</option>
                            <option value="Cuota extraordinaria">Cuota extraordinaria</option>
                            <option value="Regularización">Regularización</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Confirmar pago
                    </button>
                </div>
            </form>
            <div id="feedback-message" class="mt-4 text-sm"></div>
        </div>
        <?php endif; ?>

        <!-- Pagos realizados -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Historial de pagos
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concepto</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="historial-pagos-body" class="bg-white divide-y divide-gray-200">
                        <tr><td colspan="5" class="text-center py-4">Cargando historial...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const idUsuario = <?php echo json_encode($id_usuario); ?>;
        const idCasa = <?php echo json_encode($id_casa); ?>;
        const apiBaseUrl = '/HabitaNet/public/api';
        const tieneRecargo = <?php echo json_encode($tiene_recargo); ?>;
        const montoBase = <?php echo json_encode($cuota_actual ? $cuota_actual->getMonto() : 0); ?>;
        const recargo = <?php echo json_encode($cuota_actual ? $cuota_actual->getRecargo() : 0); ?>;

        const montoPagarHeader = document.getElementById('monto-pagar-header');
        const totalPagado = document.getElementById('total-pagado');
        const montoInput = document.getElementById('monto');
        const historialPagosBody = document.getElementById('historial-pagos-body');
        const formPago = document.getElementById('form-pago');
        const feedbackMessage = document.getElementById('feedback-message');

        async function cargarEstadoCuenta() {
            try {
                const response = await fetch(`${apiBaseUrl}/usuarios/${idUsuario}/estadoCuenta`);
                const data = await response.text(); // Primero obtenemos el texto
                let estado;
                try {
                    estado = JSON.parse(data); // Intentamos parsear como JSON
                } catch (e) {
                    console.error('Error parsing JSON:', data);
                    throw new Error('Respuesta inválida del servidor');
                }

                if (!estado.success) {
                    throw new Error(estado.error || 'Error al cargar estado');
                }

                if (estado.data) {
                    totalPagado.textContent = estado.data.total_pagado_anio || '$0.00';
                }
            } catch (error) {
                console.error('Error cargando estado de cuenta:', error);
                totalPagado.textContent = '$0.00';
            }
        }

        async function cargarHistorialPagos() {
            if (!historialPagosBody) return;
            
            try {
                const response = await fetch(`${apiBaseUrl}/pagos/usuario/${idUsuario}`);
                if (!response.ok) throw new Error('Error al cargar historial');
                const result = await response.json();

                historialPagosBody.innerHTML = '';

                if (!result.success) {
                    throw new Error(result.error || 'Error al cargar historial');
                }

                const pagos = result.data;
                if (!pagos || pagos.length === 0) {
                    historialPagosBody.innerHTML = '<tr><td colspan="5" class="text-center py-4">No hay pagos registrados.</td></tr>';
                    return;
                }

                pagos.forEach(pago => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${pago.fecha_pago_formateada}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${pago.monto}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${pago.concepto}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${pago.estado === 'Confirmado' ? 
                                `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmado
                                </span>` : 
                                `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pendiente
                                </span>`
                            }
                        </td>
                    `;
                    historialPagosBody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error cargando historial:', error);
                historialPagosBody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-red-600">Error al cargar el historial.</td></tr>`;
            }
        }

        if (formPago) {
            formPago.addEventListener('submit', async (event) => {
                event.preventDefault();

                const submitButton = formPago.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Procesando...
                `;

                if (feedbackMessage) {
                    feedbackMessage.textContent = 'Procesando pago...';
                    feedbackMessage.className = 'mt-4 text-sm text-blue-600';
                }

                try {
                    // Validar datos antes de enviar
                    const monto = parseFloat(montoInput.value.replace(/[^0-9.]/g, ''));
                    const concepto = formPago.querySelector('#concepto').value;
                    const fecha_pago = formPago.querySelector('#fecha_pago').value;

                    if (isNaN(monto) || monto <= 0) {
                        throw new Error('El monto debe ser un número válido mayor a 0');
                    }

                    if (!concepto) {
                        throw new Error('Debe seleccionar un concepto');
                    }

                    if (!fecha_pago) {
                        throw new Error('Debe seleccionar una fecha de pago');
                    }

                    // Crear objeto con los datos del formulario
                    const formData = {
                        id_usuario: idUsuario,
                        monto: monto,
                        concepto: concepto,
                        fecha_pago: fecha_pago,
                        recargo_aplicado: tieneRecargo ? 1 : 0
                    };

                    console.log('Enviando datos:', formData); // Para debugging

                    const response = await fetch(`${apiBaseUrl}/pagos`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(formData)
                    });

                    const data = await response.text(); // Primero obtenemos el texto
                    console.log('Respuesta del servidor:', data); // Para debugging

                    let result;
                    try {
                        // Intentar extraer el JSON del HTML si es necesario
                        const jsonMatch = data.match(/\{.*\}/s);
                        if (jsonMatch) {
                            result = JSON.parse(jsonMatch[0]);
                        } else {
                            result = JSON.parse(data);
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', data);
                        throw new Error('Respuesta inválida del servidor');
                    }

                    if (!result.success) {
                        throw new Error(result.error || 'Error al registrar el pago');
                    }

                    if (feedbackMessage) {
                        feedbackMessage.textContent = result.mensaje || 'Pago registrado exitosamente. Pendiente de confirmación.';
                        feedbackMessage.className = 'mt-4 text-sm text-green-600';
                    }

                    formPago.reset();
                    cargarHistorialPagos();
                    cargarEstadoCuenta();
                    
                    setTimeout(() => {
                    location.reload();
                    }, 3000);

                } catch (error) {
                    console.error('Error enviando pago:', error);
                    if (feedbackMessage) {
                        feedbackMessage.textContent = `Error: ${error.message}`;
                        feedbackMessage.className = 'mt-4 text-sm text-red-600';
                    }
                    submitButton.disabled = false;
                    submitButton.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Confirmar pago
                    `;
                }
            });
        }

        cargarEstadoCuenta();
        cargarHistorialPagos();
    });
</script>

<?php // include __DIR__ . '/../../Components/footer.php'; // Si tienes un footer ?>