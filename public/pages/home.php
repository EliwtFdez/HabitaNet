
<?php $routeLogin = "login"; ?>


<main class="container mx-auto px-4 py-8">
    <!-- Sección de Información del Proyecto -->
    <section class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Acerca de HabitaNet</h2>
        <div class="grid md:grid-cols-2 gap-8">
                <div>

                    <p class="text-gray-700 mb-6">
                        HabitaNet es un sistema integral de gestión residencial diseñado específicamente para administradores y residentes. Nuestra plataforma simplifica la gestión de pagos, mantenimiento y comunicación dentro de su comunidad.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-600 mt-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                            </span>
                            <p class="text-gray-600">Control eficiente de pagos de mantenimiento y servicios</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-600 mt-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                            </span>
                            <p class="text-gray-600">Seguimiento de solicitudes de mantenimiento en tiempo real</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-blue-600 mt-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                </svg>
                            </span>
                            <p class="text-gray-600">Gestión de documentos y comunicados importantes</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Para Administradores</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Control centralizado de pagos y adeudos</li>
                            <li>• Generación automática de reportes financieros</li>
                            <li>• Gestión de mantenimiento preventivo y correctivo</li>
                            <li>• Comunicación directa con residentes</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-lg font-semibold text-green-800 mb-2">Para Residentes</h3>
                        <ul class="text-gray-600 space-y-2">
                            <li>• Consulta de estados de cuenta</li>
                            <li>• Pagos en línea seguros</li>
                            <li>• Solicitudes de mantenimiento</li>
                            <li>• Acceso a avisos y circulares importantes</li>
                        </ul>
                    </div>
                </div>
        </div>
        <div class="mt-8 text-center">
            <a href="<?= $routeLogin ?>" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition inline-block">
                Comenzar Ahora
            </a>
        </div>
    </section>
</main>

</body>
</html>



