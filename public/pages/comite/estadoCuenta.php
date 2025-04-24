<body>
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-6">
    <h2 class="text-2xl font-bold mb-6">Estado de Cuentas</h2>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="mb-4">Consulta los estados de cuenta por periodos.</p>
        <!-- Formulario para seleccionar periodo y tipo de consulta -->
        <form method="GET" action="estadoCuenta.php" class="mb-4 flex flex-col md:flex-row gap-4 items-end">
            <div>
                <label for="periodo" class="block text-sm font-medium text-gray-700">Periodo:</label>
                <input type="month" id="periodo" name="periodo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de consulta:</label>
                <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="individual">Individual</option>
                    <option value="conjunto">Conjunto</option>
                </select>
            </div>
            <div>
                <label for="identificador" class="block text-sm font-medium text-gray-700">Identificador (opcional):</label>
                <input type="text" id="identificador" name="identificador" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="ID o nombre">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700">Consultar</button>
        </form>
        <!-- Aquí podrías mostrar los resultados de la consulta -->
        <?php
        // Ejemplo básico de manejo de la consulta (debes adaptarlo a tu lógica y base de datos)
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['periodo'], $_GET['tipo'])) {
            $periodo = htmlspecialchars($_GET['periodo']);
            $tipo = htmlspecialchars($_GET['tipo']);
            $identificador = isset($_GET['identificador']) ? htmlspecialchars($_GET['identificador']) : '';
            echo "<div class='mt-4 p-4 bg-gray-100 rounded'>";
            echo "<strong>Consulta realizada:</strong><br>";
            echo "Periodo: $periodo<br>";
            echo "Tipo: $tipo<br>";
            if ($identificador) {
                echo "Identificador: $identificador<br>";
            }
            echo "<em>Aquí se mostrarían los resultados de la consulta según los filtros seleccionados.</em>";
            echo "</div>";
        }
        ?>
    </div>
</main>
