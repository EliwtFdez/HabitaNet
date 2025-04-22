<?php
// Verificar y asegurar que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir helpers de autenticación
require_once __DIR__ . '/../includes/auth.php';
// Incluir el modelo de usuario para autenticación
require_once __DIR__ . '/../../api/Models/UserModel.php';
use Api\Models\UserModel;

// Verificar si el usuario está autenticado
if (!isLoggedIn()) {
    session_destroy();
    header('Location: login');
    exit;
}

// Validar el rol del usuario
if (!isComite() && !isInquilino()) {
    error_log("Rol no permitido: " . (getUserRole() ?: 'NULL'));
    header('Location: register');
    exit;
}

// Definición de rutas básicas
$routeLogin = "login";
$routeRegister = "register";
?>

<!-- Estructura HTML principal -->
<body class="min-h-screen flex flex-col">
    <div class="flex flex-1">
        <!-- Incluir la barra lateral -->
        <?php include __DIR__ . '/../Components/slidebar.php'; ?>

        <!-- Contenido principal -->
        <main class="flex-1 ml-64 p-8">
            <!-- Mensaje de bienvenida común para todos los roles -->
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Bienvenido, <?= htmlspecialchars($_SESSION['username']) ?></h1>
            
            <!-- SECCIONES ESPECÍFICAS POR ROL -->
            <?php if (isComite()): ?>
                <!-- SECCIÓN COMITÉ: Registro de viviendas -->
                <section class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">🏠 Registro de Viviendas</h2>
                    
                    <form class="space-y-4">
                        <div>
                            <label for="houseNumber" class="block text-gray-700 font-medium mb-2">Número de Casa</label>
                            <input 
                                type="text" 
                                id="houseNumber"
                                name="houseNumber"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                            >
                        </div>
                        
                        <div>
                            <label for="address" class="block text-gray-700 font-medium mb-2">Dirección (Opcional)</label>
                            <input 
                                type="text" 
                                id="address"
                                name="address"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                            >
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Registrar Vivienda
                        </button>
                    </form>
                </section>

                <!-- SECCIÓN COMITÉ: Reportes -->
                <section class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">📊 Reportes</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-gray-700 mb-2">Pagos Pendientes</h3>
                            <p class="text-gray-500">15 registros</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-gray-700 mb-2">Solicitudes Activas</h3>
                            <p class="text-gray-500">8 registros</p>
                        </div>
                    </div>
                </section>

            <?php elseif (isInquilino()): ?>
                <!-- SECCIÓN INQUILINO: Pagos de mantenimiento -->
                <section class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">💵 Pago de Cuota de Mantenimiento</h2>
                    
                    <div class="mb-4 bg-blue-50 p-4 rounded-lg">
                        <p class="text-blue-800 font-medium">Información de cuotas:</p>
                        <ul class="mt-2 text-sm text-blue-700">
                            <li>• Cuota mensual: $650.00 MXN</li>
                            <li>• Recargo por pago extemporáneo: $50.00 MXN</li>
                            <li>• Total de casas en el cluster: 60</li>
                        </ul>
                    </div>
                    
                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="paymentDate" class="block text-gray-700 font-medium mb-2">Fecha de Pago</label>
                                <input 
                                    type="date" 
                                    id="paymentDate"
                                    name="paymentDate"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                                >
                            </div>
                            
                            <div>
                                <label for="paymentAmount" class="block text-gray-700 font-medium mb-2">Monto a Pagar</label>
                                <input 
                                    type="number" 
                                    id="paymentAmount"
                                    name="paymentAmount"
                                    min="650"
                                    max="700"
                                    step="0.01"
                                    value="650.00"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label for="paymentConcept" class="block text-gray-700 font-medium mb-2">Concepto</label>
                            <input 
                                type="text" 
                                id="paymentConcept"
                                name="paymentConcept"
                                value="Cuota de mantenimiento mensual"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                            >
                        </div>
                        
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="latePayment"
                                name="latePayment"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="latePayment" class="ml-2 block text-gray-700">Incluir recargo por pago extemporáneo (+$50.00)</label>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                            Realizar Pago
                        </button>
                    </form>
                </section>
            
                <!-- SECCIÓN INQUILINO: Reserva de instalaciones -->
                <section class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">🏊 Reserva de Instalaciones</h2>
                    
                    <form class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Instalación a reservar</label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input id="palapa" name="facility" type="radio" value="palapa" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <label for="palapa" class="ml-2 block text-gray-700">Palapa</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="alberca" name="facility" type="radio" value="alberca" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <label for="alberca" class="ml-2 block text-gray-700">Alberca</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="reservationDate" class="block text-gray-700 font-medium mb-2">Fecha de reservación</label>
                                <input 
                                    type="date" 
                                    id="reservationDate"
                                    name="reservationDate"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                                >
                            </div>
                            
                            <div>
                                <label for="reservationTime" class="block text-gray-700 font-medium mb-2">Hora</label>
                                <input 
                                    type="time" 
                                    id="reservationTime"
                                    name="reservationTime"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                                >
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Solicitar Reservación
                        </button>
                    </form>
                </section>
            
                <!-- SECCIÓN INQUILINO: Solicitudes de servicio -->
                <section class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">🛠️ Solicitudes de Servicio/Mantenimiento</h2>
                    
                    <!-- Formulario de solicitud -->
                    <form class="space-y-4 mb-6">
                        <div>
                            <label for="serviceType" class="block text-gray-700 font-medium mb-2">Tipo de Servicio</label>
                            <select id="serviceType" name="serviceType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600">
                                <option value="">Seleccione un tipo de servicio</option>
                                <option value="mantenimiento">Mantenimiento general</option>
                                <option value="jardineria">Jardinería</option>
                                <option value="limpieza">Limpieza de áreas comunes</option>
                                <option value="seguridad">Seguridad</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="serviceDescription" class="block text-gray-700 font-medium mb-2">Descripción detallada</label>
                            <textarea 
                                id="serviceDescription"
                                name="serviceDescription"
                                rows="3"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600"
                                placeholder="Describa el servicio requerido con todos los detalles necesarios"
                            ></textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                            Enviar Solicitud
                        </button>
                    </form>
                    
                    <!-- Estado de solicitudes -->
                    <div>
                        <h3 class="font-medium text-gray-700 mb-3">Estado de tus solicitudes</h3>
                        <div class="space-y-3">
                            <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-yellow-500">
                                <div class="flex justify-between">
                                    <span class="font-medium">Mantenimiento de jardines</span>
                                    <span class="text-yellow-600 text-sm font-medium">Pendiente</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Solicitado el 15/06/2023</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-green-500">
                                <div class="flex justify-between">
                                    <span class="font-medium">Reparación de luminaria</span>
                                    <span class="text-green-600 text-sm font-medium">Atendido</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Solicitado el 10/06/2023</p>
                                <p class="text-sm text-gray-700 mt-2">Comentario: Se reparó la luminaria en la entrada principal</p>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
