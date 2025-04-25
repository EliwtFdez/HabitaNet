<?php include __DIR__ . '/../../Components/slidebar.php'; ?>
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
                    <p class="font-bold text-green-600">Al corriente</p>
                </div>
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm text-gray-500">Próxima fecha límite</p>
                    <p class="font-bold text-blue-600">10 de julio, 2024</p>
                </div>
                <div class="p-4 bg-purple-50 rounded-lg border border-purple-100">
                    <p class="text-sm text-gray-500">Total pagado</p>
                    <p class="font-bold text-purple-600">$1,950.00</p>
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
            
            <form class="space-y-4" method="POST" action="procesar_pago.php" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">Monto a pagar</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="text" id="monto" name="monto" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="650.00" readonly>
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
                    
                    <div class="md:col-span-2">
                        <label for="comprobante" class="block text-sm font-medium text-gray-700 mb-1">Subir Comprobante (PDF)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="comprobante" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Selecciona un archivo</span>
                                        <input id="comprobante" name="comprobante" type="file" class="sr-only" accept=".pdf" required>
                                    </label>
                                    <p class="pl-1">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF hasta 5MB</p>
                            </div>
                        </div>
                        <div id="file-selected" class="mt-2 text-sm text-gray-500 hidden">
                            Archivo seleccionado: <span id="file-name"></span>
                        </div>
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
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        // Conexión y consulta
                        // require '../../conexion.php';
                        // session_start();
                        // $id_usuario = $_SESSION['id_usuario'];
                        // $query = "SELECT * FROM pagos WHERE id_usuario = $id_usuario ORDER BY fecha_pago DESC";
                        // $result = mysqli_query($conn, $query);
                        // while($row = mysqli_fetch_assoc($result)):
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">01/06/2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$650.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Cuota mensual</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="comprobantes/comprobante.pdf" class="text-blue-600 hover:text-blue-900 flex items-center" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver PDF
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmado
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">01/05/2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$650.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Cuota mensual</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="comprobantes/comprobante_mayo.pdf" class="text-blue-600 hover:text-blue-900 flex items-center" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver PDF
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmado
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">01/04/2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$650.00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Cuota mensual</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="comprobantes/comprobante_abril.pdf" class="text-blue-600 hover:text-blue-900 flex items-center" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Ver PDF
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmado
                                </span>
                            </td>
                        </tr>
                        <?php // endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="mt-4 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Mostrando <span class="font-medium">3</span> de <span class="font-medium">3</span> pagos
                </div>
                <div class="flex-1 flex justify-end">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Anterior</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            1
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Siguiente</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('comprobante').addEventListener('change', function(e) {
    const fileName = e.target.files[0].name;
    document.getElementById('file-name').textContent = fileName;
    document.getElementById('file-selected').classList.remove('hidden');
});
</script>