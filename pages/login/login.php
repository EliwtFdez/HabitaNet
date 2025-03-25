<?php include('../../includes/header.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Residencias - Inicio de Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Contenido principal centrado -->
    <main class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="bg-gray-800 p-6 text-center">
                    <h2 class="text-2xl font-bold text-white">Sistema de Gestión Residencial</h2>
                    <p class="text-gray-300 mt-2">Acceso Administrativo</p>
                </div>
                
                <form action="../../controllers/loginController.php" method="POST" class="p-8">
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Correo Electrónico</label>
                        <input 
                            type="email" 
                            id="email"
                            name="usuario" 
                            required 
                            placeholder="administrador@residencias.com"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                    </div>
                    
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                        <input 
                            type="password" 
                            id="password"
                            name="clave" 
                            required 
                            placeholder="Contraseña de acceso"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                    </div>
                    
                    <div class="flex justify-between items-center mb-6">
                        <a href="#" class="text-gray-600 hover:text-gray-800 text-sm">
                            ¿Olvidó su contraseña?
                        </a>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-gray-800 text-white py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 shadow-md"
                    >
                        Iniciar Sesión
                    </button>
                    
                    <div class="text-center mt-6">
                        <p class="text-gray-600 text-sm">
                            ¿Necesita acceso? 
                            <a href="/register" class="text-gray-800 font-semibold hover:underline">
                                Contacte al administrador
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer siempre al fondo -->
    <footer class="bg-gray-800 text-white text-center py-4 text-sm">
        <?php include('../../includes/footer.php'); ?>
    </footer>

</body>
</html>
