<?php 
// Incluye el archivo del servicio de usuario necesario para el registro
require_once __DIR__ . '/../../api/Services/UserService.php';
use Api\Services\UserService;

// Configuración de rutas
$routeLogin = 'login';  // Ruta para redirección después de registro exitoso
$userService = new UserService();  // Instancia del servicio de usuario

// Lógica principal del formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación: Verifica que las contraseñas coincidan
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error = 'Las contraseñas no coinciden';
    } else {
        // Prepara los datos del usuario en formato array
        $userData = [
            'nombre' => $_POST['nombre'],      // Nombre completo del usuario
            'email' => $_POST['email'],        // Email del usuario
            'password' => $_POST['password'],  // Contraseña (debe ser hasheada en el servicio)
            'rol' => $_POST['rol']            // Rol del usuario (inquilino/comité)
        ];
        
        // Intenta registrar al usuario mediante el servicio
        $result = $userService->registerUser($userData);
        
        // Manejo de resultados del registro
        if (isset($result['message'])) {
            // Registro exitoso: Redirige a la página de login
            header("Location: $routeLogin");
            exit;
        } else {
            // Registro fallido: Guarda el error para mostrar al usuario
            $error = $result['error'] ?? 'Error desconocido al registrar usuario';
        }
    }
}
?>

<!-- Interfaz de usuario - Formulario de registro -->
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <main class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <!-- Encabezado del formulario -->
                <div class="bg-gray-800 p-6 text-center">
                    <h2 class="text-2xl font-bold text-white">Registro de Usuario</h2>
                    <p class="text-gray-300 mt-2">Cree su cuenta de administración</p>
                </div>
                
                <!-- Sección para mostrar mensajes de error -->
                <?php if (isset($error)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4">
                        <p><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>
                
                <!-- Formulario principal -->
                <form action="" method="POST" class="p-8">
                    <!-- Campo para nombre completo -->
                    <div class="mb-6">
                        <label for="nombre" class="block text-gray-700 font-semibold mb-2">Nombre Completo</label>
                        <input 
                            type="text" 
                            id="nombre"
                            name="nombre" 
                            required 
                            placeholder="Ingrese su nombre completo"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                    </div>

                    <!-- Campo para email -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Correo Electrónico</label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            required 
                            placeholder="Ingrese su correo electrónico"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                        <p class="text-gray-500 text-sm mt-2">Debe ser un correo válido y único</p>
                    </div>
                    
                    <!-- Selector de rol -->
                    <div class="mb-6">
                        <label for="rol" class="block text-gray-700 font-semibold mb-2">Tipo de Usuario</label>
                        <select 
                            id="rol"
                            name="rol" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                            <option value="">Seleccione un tipo</option>
                            <option value="inquilino">Inquilino</option>
                            <option value="comite">Miembro del Comité</option>
                        </select>
                    </div>
                    
                    <!-- Campos para contraseña -->
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            required 
                            placeholder="Cree una contraseña segura"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                        <p class="text-gray-500 text-sm mt-2">Mínimo 8 caracteres, incluya mayúsculas y números</p>
                    </div>
                    
                    <div class="mb-6">
                        <label for="confirm_password" class="block text-gray-700 font-semibold mb-2">Confirmar Contraseña</label>
                        <input 
                            type="password" 
                            id="confirm_password"
                            name="confirm_password" 
                            required 
                            placeholder="Repita su contraseña"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                    </div>
                    
                    <!-- Botón de submit -->
                    <button 
                        type="submit" 
                        class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md"
                    >
                        Crear Cuenta
                    </button>
                    
                    <!-- Enlaces adicionales -->
                    <div class="text-center mt-6">
                        <div class="flex justify-center items-center space-x-2">
                            <p class="text-gray-600 text-sm">¿Ya tiene una cuenta?</p>
                            <a href="<?php echo $routeLogin; ?>" class="text-gray-800 font-semibold hover:underline text-sm">
                                Iniciar Sesión
                            </a>
                        </div>
                        
                        <div class="mt-4">
                            <a href="#" class="text-gray-600 hover:text-gray-800 text-sm">
                                ¿Necesita ayuda?
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
