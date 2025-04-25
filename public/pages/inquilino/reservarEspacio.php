<?php include __DIR__ . '/../../Components/slidebar.php'; ?>
<main class="ml-64 p-6 bg-gray-50">
    <div class="max-w-5xl mx-auto">
        <!-- Encabezado con información de reservas -->
        <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-lg shadow-lg mb-6 p-6 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Reserva de Espacios Comunes</h2>
                    <p class="mt-1 text-green-100">Reserva la palapa o alberca para tu evento</p>
                </div>
                <div class="hidden md:block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Información sobre las reservas -->
        <div class="bg-white rounded-lg shadow-md p-5 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Información importante</h3>
            <div class="text-sm text-gray-600 space-y-2">
                <p>• Las reservas deben realizarse con al menos 2 días de anticipación.</p>
                <p>• El tiempo máximo de reserva es de 5 horas por evento.</p>
                <p>• Se permite un máximo de 20 invitados por evento.</p>
                <p>• El usuario que reserva es responsable de la limpieza después del evento.</p>
                <p>• En caso de cancelación, debe notificarse con 24 horas de anticipación.</p>
            </div>
        </div>

        <!-- Espacios disponibles -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Palapa -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1">
                <div class="h-48 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/800x400');">
                    <div class="h-full w-full bg-black bg-opacity-30 flex items-end p-4">
                        <h3 class="text-xl font-bold text-white">Palapa</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Capacidad</span>
                            <p class="text-gray-800 font-semibold">20 personas</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Horario</span>
                            <p class="text-gray-800 font-semibold">8:00 AM - 10:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Área de asador</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Mobiliario para 20 personas</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Iluminación para eventos nocturnos</span>
                        </div>
                    </div>
                    
                    <button onclick="abrirModalReserva('palapa')" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Reservar Palapa
                    </button>
                </div>
            </div>
            
            <!-- Alberca -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1">
                <div class="h-48 bg-cover bg-center" style="background-image: url('https://via.placeholder.com/800x400');">
                    <div class="h-full w-full bg-black bg-opacity-30 flex items-end p-4">
                        <h3 class="text-xl font-bold text-white">Alberca</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Capacidad</span>
                            <p class="text-gray-800 font-semibold">15 personas</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Horario</span>
                            <p class="text-gray-800 font-semibold">9:00 AM - 8:00 PM</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Área de camastros</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Vestidores y regaderas</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Área de juegos acuáticos</span>
                        </div>
                    </div>
                    
                    <button onclick="abrirModalReserva('alberca')" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Reservar Alberca
                    </button>
                </div>
            </div>
        </div>

        <!-- Mis Reservas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Mis Reservas
            </h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Espacio</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invitados</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Palapa</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">06/07/2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">14:00 - 19:00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">12</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Confirmada
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-red-600 hover:text-red-900 mr-3" onclick="cancelarReserva(1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Alberca</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">20/07/2024</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">10:00 - 15:00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">8</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pendiente
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button class="text-red-600 hover:text-red-900 mr-3" onclick="cancelarReserva(2)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal de Reserva -->
<div id="modal-reserva" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
        <button onclick="cerrarModalReserva()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        
        <h3 class="text-xl font-bold text-gray-800 mb-6" id="modal-titulo">Reservar Espacio</h3>
        
        <form id="form-reserva" class="space-y-4">
            <input type="hidden" id="tipo-espacio" name="tipo_espacio" value="">
            
            <div>
                <label for="fecha-reserva" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Reserva</label>
                <input type="date" id="fecha-reserva" name="fecha_reserva" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="hora-inicio" class="block text-sm font-medium text-gray-700 mb-1">Hora de inicio</label>
                    <select id="hora-inicio" name="hora_inicio" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                        <option value="">Seleccionar</option>
                        <option value="09:00">09:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="13:00">01:00 PM</option>
                        <option value="14:00">02:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                        <option value="16:00">04:00 PM</option>
                        <option value="17:00">05:00 PM</option>
                        <option value="18:00">06:00 PM</option>
                        <option value="19:00">07:00 PM</option>
                    </select>
                </div>
                
                <div>
                    <label for="hora-fin" class="block text-sm font-medium text-gray-700 mb-1">Hora de fin</label>
                    <select id="hora-fin" name="hora_fin" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                        <option value="">Seleccionar</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="13:00">01:00 PM</option>
                        <option value="14:00">02:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                        <option value="16:00">04:00 PM</option>
                        <option value="17:00">05:00 PM</option>
                        <option value="18:00">06:00 PM</option>
                        <option value="19:00">07:00 PM</option>
                        <option value="20:00">08:00 PM</option>
                        <option value="21:00">09:00 PM</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="num-invitados" class="block text-sm font-medium text-gray-700 mb-1">Número de invitados</label>
                <input type="number" id="num-invitados" name="num_invitados" min="1" max="20" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
            </div>
            
            <div>
                <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo del evento</label>
                <select id="motivo" name="motivo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" required>
                    <option value="">Seleccionar</option>
                    <option value="Cumpleaños">Cumpleaños</option>
                    <option value="Reunión familiar">Reunión familiar</option>
                    <option value="Parrillada">Parrillada</option>
                    <option value="Convivio">Convivio</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            
            <div id="otro-motivo-container" class="hidden">
                <label for="otro-motivo" class="block text-sm font-medium text-gray-700 mb-1">Especifique motivo</label>
                <input type="text" id="otro-motivo" name="otro_motivo" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
            </div>
            
            <div>
                <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">Notas adicionales</label>
                <textarea id="notas" name="notas" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"></textarea>
            </div>
            
            <div class="pt-4">
                <div class="flex items-center justify-center">
                    <input type="checkbox" id="aceptar-reglas" name="aceptar_reglas" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" required>
                    <label for="aceptar-reglas" class="ml-2 block text-sm text-gray-700">
                        Acepto las reglas de uso del espacio y me hago responsable del área durante el evento
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end pt-4">
                <button type="button" onclick="cerrarModalReserva()" class="mr-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Cancelar
                </button>
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Confirmar Reserva
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Función para abrir el modal de reserva
    function abrirModalReserva(tipo) {
        document.getElementById('modal-reserva').classList.remove('hidden');
        document.getElementById('tipo-espacio').value = tipo;
        document.getElementById('modal-titulo').innerText = 'Reservar ' + (tipo === 'palapa' ? 'Palapa' : 'Alberca');
    }
    
    // Función para cerrar el modal de reserva
    function cerrarModalReserva() {
        document.getElementById('modal-reserva').classList.add('hidden');
        document.getElementById('form-reserva').reset();
    }
    
    // Función para cancelar una reserva
    function cancelarReserva(id) {
        if (confirm('¿Estás seguro de que deseas cancelar esta reserva?')) {
            // Aquí iría el código para cancelar la reserva en la base de datos
            alert('Reserva cancelada con éxito');
        }
    }
    
    // Mostrar campo de "otro motivo" cuando se selecciona "Otro"
    document.getElementById('motivo').addEventListener('change', function() {
        if (this.value === 'Otro') {
            document.getElementById('otro-motivo-container').classList.remove('hidden');
        } else {
            document.getElementById('otro-motivo-container').classList.add('hidden');
        }
    });
    
    // Validar formulario antes de enviar
    document.getElementById('form-reserva').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Aquí iría el código para enviar la reserva a la base de datos
        // Simulación de envío exitoso
        alert('Reserva enviada con éxito. Recibirás confirmación por correo electrónico.');
        cerrarModalReserva();
    });
</script>