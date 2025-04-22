<?php 
// Incluye el modelo de usuario necesario para la autenticación
require_once __DIR__ . '/../../api/Models/UserModel.php';
use Api\Models\UserModel;

// Definición de rutas para redirección
$routeRegister = "register";  // Ruta al formulario de registro
$routeInitSeccion = "dashboard";  // Ruta al dashboard después de login

// Variables para control de estado
$userFound = null;  // Null: no se ha intentado login, false: login fallido
$email = $_POST['usuario'] ?? '';  // Obtiene email del formulario o cadena vacía
$password = $_POST['clave'] ?? '';  // Obtiene contraseña del formulario o cadena vacía

// Instancia del modelo de usuario
$userModel = new UserModel();

// Lógica principal de autenticación
if (!empty($email) && !empty($password)) {
    // Intenta autenticar al usuario con las credenciales proporcionadas
    $user = $userModel->authenticate($email, $password);
    
    if ($user) {
        // Autenticación exitosa:
        // 1. Regenera el ID de sesión por seguridad
        // 2. Establece variables de sesión
        // 3. Redirige al dashboard
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;  // Flag de sesión activa
        $_SESSION['user_id'] = $user['id'];  // ID del usuario
        $_SESSION['username'] = $user['nombre'];  // Nombre del usuario
        $_SESSION['user_role'] = $user['rol'];  // Rol del usuario
        header("Location: $routeInitSeccion");
        exit;
    } else {
        // Autenticación fallida
        $userFound = false;  // Marca el intento como fallido
    }
}
?>

<!-- Interfaz de usuario -->
<main class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <!-- Encabezado del formulario -->
            <div class="bg-gray-800 p-6 text-center">
                <h2 class="text-2xl font-bold text-white">Sistema de Gestión Residencial</h2>
                <p class="text-gray-300 mt-2">Acceso Administrativo</p>
            </div>
            
            <!-- Formulario de login -->
            <form action="login" method="POST" class="p-8">
                <!-- Campo email -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        Correo Electrónico
                    </label>
                    <input 
                        type="email" 
                        id="email"
                        name="usuario" 
                        required 
                        placeholder="administrador@residencias.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                    >
                </div>
                
                <!-- Campo contraseña -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        Contraseña
                    </label>
                    <input 
                        type="password" 
                        id="password"
                        name="clave" 
                        required 
                        placeholder="Contraseña de acceso"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                    >
                </div>
                
                <!-- Botón de submit -->
                <button 
                    type="submit"
                    class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md"
                >
                    Iniciar Sesión
                </button>
                
                <!-- Enlace a registro -->
                <div class="mt-6 bg-gray-100 p-4 rounded-md text-center">
                    <p class="text-gray-700">
                        ¿Aún no estás registrado? 
                        <a href="<?php echo $routeRegister; ?>" class="text-blue-600 hover:underline font-medium">
                            Haz clic aquí para crear una cuenta
                        </a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Mensaje de error (solo visible cuando $userFound es false) -->
        <?php if ($userFound === false): ?>
            <div class="mt-4 p-4 bg-red-100 text-red-800 rounded">
                Usuario no encontrado o contraseña incorrecta.
            </div>
        <?php endif; ?>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>