<?php
require_once __DIR__ . '/../includes/auth.php';

// Verificar si el usuario ha iniciado sesión
if (!isLoggedIn()) {
    return;
}

// Obtener el rol del usuario usando la función helper
$currentRole = getUserRole();
$currentUri = $_SERVER['REQUEST_URI']; // Obtener la URI actual para comparación
?>

<aside class="w-64 bg-gray-800 text-white min-h-screen fixed">
    <div class="p-4">
        <!-- Título del sistema -->
        <h1 class="text-xl font-bold mb-8">HabitaNet</h1>

        <?php if (isComite()): ?>
            <!-- Menú específico para el comité -->
            <div class="space-y-2">
                <h3 class="text-sm font-semibold text-gray-400 mb-2">MÓDULO COMITÉ</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/HabitaNet/public/comite/estadoCuenta" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/comite/estadoCuenta' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Estado de Cuentas</span>
                        </a>
                    </li>
                    <li>
                        <a href="/HabitaNet/public/comite/registroEgreso" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/comite/registroEgreso' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Registrar Egreso</span>
                        </a>
                    </li>
                    <li>
                        <a href="/HabitaNet/public/comite/reporteMensual" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/comite/reporteMensual' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Reporte Mensual</span>
                        </a>
                    </li>
                    <li>
                        <a href="/HabitaNet/public/comite/acuseRecibo" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/comite/acuseRecibo' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Acuse de Recibo</span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php elseif (isInquilino()): ?>
            <!-- Menú específico para inquilinos -->
            <div class="space-y-2">
                <h3 class="text-sm font-semibold text-gray-400 mb-2">MÓDULO INQUILINO</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="/HabitaNet/public/inquilino/pagoCuota" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/inquilino/pagoCuota' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Pagar Cuota</span>
                        </a>
                    </li>
                    <li>
                        <a href="/HabitaNet/public/inquilino/reservarEspacio" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/inquilino/reservarEspacio' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Reservar Espacio</span>
                        </a>
                    </li>
                    <li>
                        <a href="/HabitaNet/public/inquilino/solicitarServicio" class="flex items-center p-2 rounded-lg hover:bg-gray-700 <?php echo ($currentUri == '/HabitaNet/public/inquilino/solicitarServicio' ? 'shadow-lg bg-gray-900' : 'text-gray-300'); ?>">
                            <span>Solicitar Servicio</span>
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Sección de cierre de sesión -->
        <div class="mt-8 pt-4 border-t border-gray-700">
            <form action="/HabitaNet/public/logout" method="POST"> <!-- Asegúrate que la acción del logout sea correcta -->
                <button type="submit" class="flex items-center space-x-2 p-2 hover:bg-gray-700 rounded-lg w-full text-gray-300">
                    <i class="mdi mdi-logout"></i> <!-- Considera añadir un icono si usas una librería como Material Design Icons -->
                    <span>Cerrar sesión</span>
                </button>
            </form>
        </div>
    </div>
</aside>
