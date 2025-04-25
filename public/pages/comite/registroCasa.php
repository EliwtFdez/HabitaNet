<?php
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_casa = $_POST['numero_casa'] ?? '';
    $id_inquilino = $_POST['id_inquilino'] ?? null;

    // Validar el límite de casas
    $query = "SELECT COUNT(*) as total FROM casas";
    $resultado = $conn->query($query);
    $fila = $resultado->fetch_assoc();

    if ($fila['total'] >= 60) {
        $error = "No se pueden registrar más casas. Límite alcanzado.";
    } else {
        // Verificar si el número de casa ya existe
        $query = "SELECT id FROM casas WHERE numero_casa = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $numero_casa);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "El número de casa ya existe.";
        } else {
            // Insertar la nueva casa
            $query = "INSERT INTO casas (numero_casa, id_inquilino) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $numero_casa, $id_inquilino);
            
            if ($stmt->execute()) {
                $mensaje = "Casa registrada exitosamente.";
            } else {
                $error = "Error al registrar la casa: " . $conn->error;
            }
        }
    }
}

// Obtener lista de inquilinos para el select
$queryInquilinos = "SELECT id, nombre FROM usuarios WHERE rol = 'inquilino'";
$resultadoInquilinos = $conn->query($queryInquilinos);
?>

<body>
    <?php include __DIR__ . '/../../Components/slidebar.php'; ?>

    <main class="ml-64 p-8 bg-gray-100 min-h-screen">
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-3xl font-bold text-indigo-700 mb-6 text-center">
                Registro de Nueva Casa
            </h2>

            <?php if ($mensaje): ?>
            <div class="alert alert-success mb-4" role="alert">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-danger mb-4" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="form-label text-gray-700">Número de Casa</label>
                    <input type="text" name="numero_casa" required 
                        class="form-control border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label class="form-label text-gray-700">Inquilino (opcional)</label>
                    <select name="id_inquilino" class="form-select border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccionar inquilino</option>
                        <?php while ($inquilino = $resultadoInquilinos->fetch_assoc()): ?>
                            <option value="<?php echo $inquilino['id']; ?>">
                                <?php echo htmlspecialchars($inquilino['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit"
                            class="btn btn-primary bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition duration-200">
                        Registrar Casa
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
