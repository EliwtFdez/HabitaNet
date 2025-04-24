<body>
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-6">
        <h2 class="text-2xl font-bold mb-6">Pago de Cuota Mensual</h2>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <form class="space-y-4">
                <div>
                    <label class="block mb-2">Monto</label>
                    <input type="number" class="w-full p-2 border rounded" value="1000" readonly>
                </div>
                <div>
                    <label class="block mb-2">Fecha</label>
                    <input type="date" class="w-full p-2 border rounded">
                </div>
                <button type="submit" class="bg-green-500 text-white p-2 rounded">Pagar</button>
            </form>
        </div>

        <!-- Pagos realizados -->
        <div class="bg-white p-6 rounded-lg shadow mt-8">
            <h3 class="text-xl font-bold mb-4">Pagos realizados</h3>
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Fecha de Pago</th>
                        <th class="px-4 py-2">Monto</th>
                        <th class="px-4 py-2">Recargo</th>
                        <th class="px-4 py-2">Concepto</th>
                        <th class="px-4 py-2">Comprobante</th>
                        <th class="px-4 py-2">Confirmado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Ejemplo de conexión y consulta (ajusta según tu configuración)
                    // $conn = new mysqli('localhost', 'usuario', 'contraseña', 'residencias');
                    // $id_usuario = $_SESSION['id_usuario']; // Ajusta según tu sistema de login
                    // $result = $conn->query("SELECT * FROM pagos WHERE id_usuario = $id_usuario ORDER BY fecha_pago DESC");
                    // while($row = $result->fetch_assoc()):
                    ?>
                    <!-- Ejemplo de fila estática, reemplaza por el bucle PHP -->
                    <tr>
                        <td class="border px-4 py-2">2024-06-01</td>
                        <td class="border px-4 py-2">$650.00</td>
                        <td class="border px-4 py-2">No</td>
                        <td class="border px-4 py-2">Cuota mensual</td>
                        <td class="border px-4 py-2">comprobante.pdf</td>
                        <td class="border px-4 py-2">Sí</td>
                    </tr>
                    <?php //endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
