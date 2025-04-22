<?php include __DIR__ . '/../includes/header.php'; ?>

<main class="container mx-auto p-4">
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
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>