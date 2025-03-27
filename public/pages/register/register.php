<?php include('includes/header.php'); 
$routeLogin= '/login';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario - Gestión Residencial</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="bg-gray-800 p-6 text-center">
                <h2 class="text-2xl font-bold text-white">Registro de Usuario</h2>
                <p class="text-gray-300 mt-2">Cree su cuenta de administración</p>
            </div>
            
            <form action="Controllers/registerController.php" method="POST" class="p-8">
                <div class="mb-6">
                    <label for="usuario" class="block text-gray-700 font-semibold mb-2">Nombre de Usuario</label>
                    <input 
                        type="text" 
                        id="usuario"
                        name="usuario" 
                        required 
                        placeholder="Ingrese su nombre de usuario"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                    >
                    <p class="text-gray-500 text-sm mt-2">Utilice un nombre de usuario único</p>
                </div>
                
                <div class="mb-6">
                    <label for="clave" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                    <input 
                        type="password" 
                        id="clave"
                        name="clave" 
                        required 
                        placeholder="Cree una contraseña segura"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                    >
                    <p class="text-gray-500 text-sm mt-2">Mínimo 8 caracteres, incluya mayúsculas y números</p>
                </div>
                
                <div class="mb-6">
                    <label for="confirmar-clave" class="block text-gray-700 font-semibold mb-2">Confirmar Contraseña</label>
                    <input 
                        type="password" 
                        id="confirmar-clave"
                        name="confirmar-clave" 
                        required 
                        placeholder="Repita su contraseña"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                    >
                </div>
                
                <button 
                    type="submit" 
                    class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md"
                >
                    Crear Cuenta
                </button>
                
                <div class="text-center mt-6">
                    <p class="text-gray-600 text-sm">
                        ¿Ya tiene una cuenta? 
                        <a href="<?php echo $routeLogin; ?>" class="text-gray-800 font-semibold hover:underline">
                            Iniciar Sesión
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
<?php include('../../includes/footer.php');?>