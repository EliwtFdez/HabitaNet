<body>
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-6">
        <h2 class="text-2xl font-bold mb-6">Solicitar Servicio</h2>
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <form class="space-y-4" method="POST" action="procesarSolicitud.php">
                <div>
                    <label class="block mb-2">Tipo de servicio</label>
                    <select name="tipo" class="w-full p-2 border rounded" required>
                        <option value="">Selecciona una opción</option>
                        <option value="alberca">Alberca</option>
                        <option value="palapa">Palapa</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2">Comentario</label>
                    <textarea name="comentario" class="w-full p-2 border rounded" rows="3" placeholder="Describe tu solicitud"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Enviar solicitud</button>
            </form>
        </div>

        <!-- Historial de solicitudes -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Historial de solicitudes</h3>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Comentario</th>
                        <th class="px-4 py-2">Estatus</th>
                        <th class="px-4 py-2">Respuesta</th>
                        <th class="px-4 py-2">Fecha de respuesta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ejemplo de consulta (ajusta según tu sistema de autenticación y conexión)
                    // $conn = new mysqli('localhost', 'usuario', 'contraseña', 'residencias');
                    // $id_usuario = $_SESSION['id_usuario'];
                    // $result = $conn->query("SELECT * FROM solicitudes_servicios WHERE id_usuario = $id_usuario ORDER BY fecha_solicitud DESC");
                    // while($row = $result->fetch_assoc()):
                    ?>
                    <!-- Ejemplo de fila estática, reemplaza por el bucle PHP -->
                    <tr>
                        <td class="border px-4 py-2">2024-06-01</td>
                        <td class="border px-4 py-2">Alberca</td>
                        <td class="border px-4 py-2">Solicito limpieza</td>
                        <td class="border px-4 py-2">Pendiente</td>
                        <td class="border px-4 py-2">-</td>
                        <td class="border px-4 py-2">-</td>
                    </tr>
                    <?php //endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
