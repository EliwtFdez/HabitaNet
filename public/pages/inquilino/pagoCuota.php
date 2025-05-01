<?php
include __DIR__ . '/../../Components/slidebar.php';
?>

<main class="ml-64 p-6 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <!-- Encabezado con información de pago -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg mb-6 p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Pago de Cuota Mensual</h2>
                    <p class="mt-1 text-blue-100">Realiza tu pago mensual de manera fácil y segura</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-100">Monto a pagar:</p>
                    <!-- Se actualizará con JS -->
                    <p class="text-3xl font-bold">$650.00 MXN</p>
                </div>
            </div>
        </div>

        <!-- Estado de cuenta resumen -->
        <div class="bg-white rounded-lg shadow-md p-5 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Estado de cuenta</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-green-50 rounded-lg border border-green-100">
                    <p class="text-sm text-gray-500">Estatus actual</p>
                    <!-- Se actualizará con JS -->
                    <p class="font-bold text-green-600" id="estatus-actual">Cargando...</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-500">Próxima fecha límite</p>
                    <!-- Se actualizará con JS -->
                    <p class="font-bold text-blue-600" id="fecha-limite">Cargando...</p>
                </div>
                <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
                    <p class="text-sm text-gray-500">Total pagado (Año)</p>
                     <!-- Se actualizará con JS -->
                    <p class="font-bold text-purple-600" id="total-pagado">Cargando...</p>
                </div>
            </div>
        </div>

        <!-- Formulario para nuevo pago -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                Realizar nuevo pago
            </h3>

            <!-- Modificamos el form para quitar action y manejarlo con JS -->
            <form id="form-pago" class="space-y-4" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">Monto a pagar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <!-- Se actualizará con JS, mantenemos readonly -->
                            <input type="text" id="monto" name="monto" value="650.00" readonly
                            class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div>
                        <label for="fecha_pago" class="block text-sm font-medium text-gray-700 mb-1">Fecha de pago</label>
                        <input type="date" id="fecha_pago" name="fecha_pago" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="concepto" class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                        <select id="concepto" name="concepto" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
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
<input type="hidden" id="recargo_aplicado" name="recargo_aplicado" value="false">

                        Confirmar pago
                    </button>
                </div>
            </form>
             <!-- Mensaje de feedback -->
            <div id="feedback-message" class="mt-4 text-sm"></div>
        </div>

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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comprobante</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <!-- El cuerpo de la tabla se llenará con JS -->
                    <tbody id="historial-pagos-body" class="bg-white divide-y divide-gray-200">
                        <!-- Filas de ejemplo eliminadas, se cargarán dinámicamente -->
                         <tr><td colspan="5" class="text-center py-4">Cargando historial...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Script para interactuar con la API -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const idUsuario = <?php echo json_encode($id_usuario); ?>; // Obtener ID de usuario desde PHP
        const apiBaseUrl = '/api'; // Ajusta si tu base de API es diferente

        const montoPagarHeader = document.getElementById('monto-pagar-header');
        const estatusActual = document.getElementById('estatus-actual');
        const fechaLimite = document.getElementById('fecha-limite');
        const totalPagado = document.getElementById('total-pagado');
        const montoInput = document.getElementById('monto');
        const historialPagosBody = document.getElementById('historial-pagos-body');
        const formPago = document.getElementById('form-pago');
        const feedbackMessage = document.getElementById('feedback-message');
        const fileInput = document.getElementById('comprobante');
        const fileSelectedDiv = document.getElementById('file-selected');
        const fileNameSpan = document.getElementById('file-name');

        // --- Add checks for critical elements ---
        if (!formPago) {
            console.error("Error: Element with ID 'form-pago' not found. Cannot attach form submit listener.");
            feedbackMessage.textContent = 'Error interno: No se pudo inicializar el formulario.';
            feedbackMessage.className = 'mt-4 text-sm text-red-600';
            return; // Stop script execution if critical form element is missing
        }
        // Add warnings for non-critical display elements if they are missing
        if (!fileSelectedDiv) console.warn("Warning: Element with ID 'file-selected' not found.");
        if (!fileNameSpan) console.warn("Warning: Element with ID 'file-name' not found.");
        if (!historialPagosBody) console.warn("Warning: Element with ID 'historial-pagos-body' not found.");
        // Add more checks for header/status elements if needed


        // --- Funciones para cargar datos ---

        async function cargarEstadoCuenta() {
             try {
                // Endpoint hipotético para obtener estado de cuenta (necesitarás crearlo)
                // Podría devolver { estatus: 'Al corriente', total_pagado_anio: 1950.00 }
                const response = await fetch(`${apiBaseUrl}/usuarios/${idUsuario}/estadoCuenta`); // Ajusta el endpoint
                if (!response.ok) throw new Error('Error al cargar estado');
                const estado = await response.json();

                estatusActual.textContent = estado.estatus;
                totalPagado.textContent = `$${parseFloat(estado.total_pagado_anio).toFixed(2)}`;

            } catch (error) {
                console.error('Error cargando estado de cuenta:', error);
                estatusActual.textContent = 'Error';
                totalPagado.textContent = 'Error';
            }
        }


        async function cargarHistorialPagos() {
            // Check if the table body exists before trying to update it
            if (!historialPagosBody) {
                console.error("Cannot load payment history: 'historial-pagos-body' element not found.");
                return;
            }
            try {
                // Usamos el endpoint del PagoController
                const response = await fetch(`${apiBaseUrl}/pagos/usuario/${idUsuario}`);
                if (!response.ok) throw new Error('Error al cargar historial');
                const pagos = await response.json();

                historialPagosBody.innerHTML = ''; // Limpiar 'Cargando...'

                if (pagos.length === 0) {
                    historialPagosBody.innerHTML = '<tr><td colspan="5" class="text-center py-4">No hay pagos registrados.</td></tr>';
                    return;
                }

                pagos.forEach(pago => {
                    const tr = document.createElement('tr');
                    tr.classList.add('hover:bg-gray-50');

                    const estadoConfirmacion = pago.confirmado_por
                        ? `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Confirmado</span>`
                        : `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>`;

                    const linkComprobante = pago.comprobante_pago
                        ? `<a href="/uploads/comprobantes/${pago.comprobante_pago}" class="text-blue-600 hover:text-blue-900 flex items-center" target="_blank">
                               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                               </svg>
                               Ver PDF
                           </a>`
                        : 'N/A';

                    tr.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatearFecha(pago.fecha_pago)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${parseFloat(pago.monto).toFixed(2)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${pago.concepto}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">${linkComprobante}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${estadoConfirmacion}</td>
                    `;
                    historialPagosBody.appendChild(tr);
                });

            } catch (error) {
                console.error('Error cargando historial:', error);
                // Check again before updating on error
                if (historialPagosBody) {
                    historialPagosBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-red-500">Error al cargar el historial.</td></tr>`;
                }
            }
        }

        // --- Manejo del formulario ---

        // Now safe to add listener because we checked fileInput above
        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            // Check dependent elements *inside* the handler as well
            if (fileNameSpan && fileSelectedDiv) {
                if (file) {
                    fileNameSpan.textContent = file.name;
                    fileSelectedDiv.classList.remove('hidden');
                } else {
                    fileNameSpan.textContent = '';
                    fileSelectedDiv.classList.add('hidden');
                }
            } else {
                 console.error("Error: Cannot update file name display. 'file-name' or 'file-selected' element missing.");
            }
        });

        // Now safe to add listener because we checked formPago above
        formPago.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevenir envío tradicional

            // Check feedback element exists before using it
            if (feedbackMessage) {
                feedbackMessage.textContent = 'Procesando pago...';
                feedbackMessage.className = 'mt-4 text-sm text-blue-600';
            } else {
                console.warn("Feedback message element not found.");
            }

            // Verifica si hay recargo según la fecha seleccionada
            const fechaSeleccionada = new Date(formData.get('fecha_pago'));
            const hoy = new Date();
            const limite = new Date(hoy.getFullYear(), hoy.getMonth(), 10); // Límite: día 10 del mes actual

            if (fechaSeleccionada > limite) {
                formData.set('recargo_aplicado', true);
                formData.set('monto', "700.00"); // 650 + 50
                montoInput.value = "700.00";
            } else {
                formData.set('recargo_aplicado', false);
                formData.set('monto', "650.00");
                montoInput.value = "650.00";
            }


            const formData = new FormData(formPago);
            formData.append('id_usuario', idUsuario);
            // Asumimos que tienes el id_casa disponible, si no, necesitarás obtenerlo
            // formData.append('id_casa', idCasa); // Descomenta y asigna si es necesario

            // Validar fecha (ejemplo básico)
            if (!formData.get('fecha_pago')) {
                 if (feedbackMessage) {
                     feedbackMessage.textContent = 'Por favor, selecciona la fecha de pago.';
                     feedbackMessage.className = 'mt-4 text-sm text-red-600';
                 }
                 return;
            }
             // Validar archivo - Use fileInput directly as formData might not reflect file selection state accurately before send
            if (!fileInput.files || fileInput.files.length === 0) {
                 if (feedbackMessage) {
                     feedbackMessage.textContent = 'Por favor, selecciona un archivo de comprobante.';
                     feedbackMessage.className = 'mt-4 text-sm text-red-600';
                 }
                 return;
            }


            try {
                // Usamos el endpoint del PagoController para crear
                const response = await fetch(`${apiBaseUrl}/pagos`, {
                    method: 'POST',
                    body: formData // FormData maneja automáticamente el enctype="multipart/form-data"
                    // No necesitas 'Content-Type' header cuando usas FormData con fetch, el navegador lo establece
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || 'Error al registrar el pago');
                }

                if (feedbackMessage) {
                    feedbackMessage.textContent = result.mensaje || 'Pago registrado exitosamente. Pendiente de confirmación.';
                    feedbackMessage.className = 'mt-4 text-sm text-green-600';
                }
                formPago.reset(); // Limpiar formulario
                // Manually clear file display elements after reset
                if (fileNameSpan) fileNameSpan.textContent = '';
                if (fileSelectedDiv) fileSelectedDiv.classList.add('hidden');

                cargarHistorialPagos(); // Recargar historial
                cargarEstadoCuenta(); // Recargar estado de cuenta

            } catch (error) {
                console.error('Error enviando pago:', error);
                 if (feedbackMessage) {
                    feedbackMessage.textContent = `Error: ${error.message}`;
                    feedbackMessage.className = 'mt-4 text-sm text-red-600';
                 }
            }
        });

        // --- Funciones auxiliares ---
        function formatearFecha(fechaString) {
            if (!fechaString) return 'N/A';
            try {
                const fecha = new Date(fechaString + 'T00:00:00'); // Asegurar que se interprete como local
                const dia = String(fecha.getDate()).padStart(2, '0');
                const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Meses son 0-indexados
                const anio = fecha.getFullYear();
                return `${dia}/${mes}/${anio}`;
            } catch (e) {
                return fechaString; // Devolver original si falla
            }
        }


        cargarEstadoCuenta();
        cargarHistorialPagos();
    });
</script>

<?php // include __DIR__ . '/../../Components/footer.php'; // Si tienes un footer ?>