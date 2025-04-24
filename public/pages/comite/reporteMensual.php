<body>
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-6">
    <h2 class="text-2xl font-bold mb-6">reporte del mes</h2>
    
    <div class="bg-white p-6 rounded-lg shadow">
        <form class="space-y-4">
            <div>
                <label class="block mb-2">Monto</label>
                <input type="number" class="w-full p-2 border rounded">
            </div>
            <div>
                <label class="block mb-2">Destinatario</label>
                <input type="text" class="w-full p-2 border rounded">
            </div>
            <!-- More form fields will be added -->
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Registrar</button>
        </form>
    </div>
</main>

