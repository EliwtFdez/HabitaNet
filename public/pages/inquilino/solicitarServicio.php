<?php include __DIR__ . '/../../Components/slidebar.php'; ?>
<main class="ml-64 p-6 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <!-- Encabezado con información de servicios -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-lg shadow-lg mb-6 p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Foro de Servicios y Mantenimiento</h2>
                    <p class="mt-1 text-purple-100">Solicita servicios al comité y visualiza el estado de las peticiones comunitarias</p>
                </div>
                <div class="hidden md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Estadísticas de servicios -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center">
                <div class="rounded-full bg-green-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Resueltos</p>
                    <p class="text-xl font-bold text-gray-800">24</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">En proceso</p>
                    <p class="text-xl font-bold text-gray-800">7</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center">
                <div class="rounded-full bg-yellow-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Pendientes</p>
                    <p class="text-xl font-bold text-gray-800">3</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-xl font-bold text-gray-800">34</p>
                </div>
            </div>
        </div>

        <!-- Formulario para nueva solicitud -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Nueva Solicitud de Servicio
            </h3>
            
            <form class="space-y-4" method="POST" action="procesarSolicitud.php" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de servicio</label>
                        <select id="tipo" name="tipo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" required>
                            <option value="">Selecciona una opción</option>
                            <option value="alberca">Alberca</option>
                            <option value="palapa">Palapa</option>
                            <option value="jardineria">Jardinería</option>
                            <option value="iluminacion">Iluminación</option>
                            <option value="seguridad">Seguridad</option>
                            <option value="plomeria">Plomería</option>
                            <option value="electricidad">Electricidad</option>
                            <option value="limpieza">Limpieza de áreas comunes</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="ubicacion" class="block text-sm font-medium text-gray-700 mb-1">Ubicación/Área</label>
                        <input type="text" id="ubicacion" name="ubicacion" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Especifica la ubicación exacta" required>
                    </div>
                </div>
                
                <div>
                    <label for="asunto" class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                    <input type="text" id="asunto" name="asunto" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Breve descripción del problema" required>
                </div>
                
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción detallada</label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50" placeholder="Describe el problema con el mayor detalle posible para facilitar su atención" required></textarea>
                </div>
                
                <div>
                    <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                    <div class="flex space-x-4">
                        <div class="flex items-center">
                            <input type="radio" id="prioridad-baja" name="prioridad" value="baja" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                            <label for="prioridad-baja" class="ml-2 block text-sm text-gray-700">Baja</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="prioridad-media" name="prioridad" value="media" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300" checked>
                            <label for="prioridad-media" class="ml-2 block text-sm text-gray-700">Media</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="prioridad-alta" name="prioridad" value="alta" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                            <label for="prioridad-alta" class="ml-2 block text-sm text-gray-700">Alta</label>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imágenes (opcional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-purple-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="imagenes" class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500">
                                    <span>Subir imágenes</span>
                                    <input id="imagenes" name="imagenes[]" type="file" class="sr-only" multiple accept="image/*">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF hasta 5MB</p>
                        </div>
                    </div>
                    <div id="selected-images" class="mt-2 flex flex-wrap gap-2"></div>
                </div>
                
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Enviar solicitud
                    </button>
                </div>
            </form>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-4">
                    <div>
                        <label for="filtro-tipo" class="block text-xs font-medium text-gray-700 mb-1">Tipo</label>
                        <select id="filtro-tipo" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="alberca">Alberca</option>
                            <option value="palapa">Palapa</option>
                            <option value="jardineria">Jardinería</option>
                            <option value="otro">Otros</option>
                        </select>
                    </div>
                    <div>
                        <label for="filtro-estado" class="block text-xs font-medium text-gray-700 mb-1">Estado</label>
                        <select id="filtro-estado" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="proceso">En proceso</option>
                            <option value="resuelto">Resuelto</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div>
                        <label for="filtro-fecha" class="block text-xs font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" id="filtro-fecha" class="text-sm rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-500 focus:ring-opacity-50">
                    </div>
                </div>
                <div class="flex items-end">
                    <button id="btn-filtrar" class="py-1.5 px-3 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-md text-sm font-medium transition-colors">
                        Aplicar filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Foro de solicitudes comunitarias -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg>
                Foro de solicitudes comunitarias
            </h3>
            
            <div class="space-y-6">
                <!-- Solicitud 1 -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-medium text-gray-900">Fuga de agua en área común</h4>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">Plomería</span>
                                <span class="text-sm text-gray-500">Área de alberca</span>
                            </div>
                        </div>
                        <div>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                En proceso
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-3">
                        Se observa una fuga de agua importante en la tubería cercana a la alberca. El agua está acumulándose y podría causar daños mayores si no se atiende pronto.
                    </p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Carlos Mendoza</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>22 Jun 2024, 14:30</span>
                        </div>
                    </div>
                    
                    <!-- Actualización del comité -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium text-blue-800">Actualización del comité</span>
                            </div>
                            <p class="text-sm text-gray-700">
                                El plomero ya revisó la fuga y determinó que es necesario reemplazar una sección de la tubería. Los materiales han sido ordenados y el trabajo se realizará mañana a las 9:00 AM.
                            </p>
                            <div class="flex justify-between items-center text-xs text-gray-500 mt-2">
                                <span>Comité de Administración</span>
                                <span>23 Jun 2024, 10:15</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Solicitud 2 -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-medium text-gray-900">Luminarias fundidas en estacionamiento</h4>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">Electricidad</span>
                                <span class="text-sm text-gray-500">Estacionamiento norte</span>
                            </div>
                        </div>
                        <div>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Resuelto
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-3">
                        Tres luminarias del estacionamiento norte están fundidas, lo que genera poca visibilidad por las noches y representa un problema de seguridad.
                    </p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>María Jiménez</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>20 Jun 2024, 19:45</span>
                        </div>
                    </div>
                    
                    <!-- Actualización del comité -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="bg-green-50 p-3 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="font-medium text-green-800">Servicio completado</span>
                            </div>
                            <p class="text-sm text-gray-700">
                                Se reemplazaron las 3 luminarias fundidas por nuevas de tecnología LED que proporcionan mayor iluminación y consumen menos energía. Adicionalmente, se revisó el sistema eléctrico para prevenir futuros fallos.
                            </p>
                            <div class="flex justify-between items-center text-xs text-gray-500 mt-2">
                                <span>Comité de Mantenimiento</span>
                                <span>21 Jun 2024, 16:20</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Solicitud 3 -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h4 class="font-medium text-gray-900">Mantenimiento de áreas verdes</h4>
                            <div class="flex items-center mt-1 space-x-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">Jardinería</span>
                                <span class="text-sm text-gray-500">Jardín central</span>
                            </div>
                        </div>
                        <div>
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Pendiente
                            </span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-3">
                        El césped del jardín central está muy crecido y algunas plantas necesitan poda. Se requiere mantenimiento general del área verde para mejorar la apariencia del conjunto.
                    </p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Roberto Guzmán</span>
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>24 Jun 2024, 09:15</span>
                        </div>
                    </div>
                    
                    <!-- Sin actualización aún -->
                </div>
            </div>
            
            <!-- Paginación -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Mostrando <span class="font-medium">3</span> de <span class="font-medium">34</span> solicitudes
                </div>
                <div class="flex-1 flex justify-end">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Anterior</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            <path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L7 10.414a1 1 0 011.414-1.414L12 12.586l3.586-3.586a1 1 0 111.414 1.414l-4.293 4.293z" clip-rule="evenodd" />
                        </svg>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            1
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            2
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                            3
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Siguiente</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>
