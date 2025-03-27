<?php $routeRegister = "register"; ?>
    <!-- Contenido principal centrado -->
    <main class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="bg-gray-800 p-6 text-center">
                    <h2 class="text-2xl font-bold text-white">Sistema de Gestión Residencial</h2>
                    <p class="text-gray-300 mt-2">Acceso Administrativo</p>
                </div>
                
                <form action="../../controllers/loginController.php" method="POST" class="p-8">
                    <div class="mb-6">
                        <label for="username" class="block text-gray-700 font-semibold mb-2">Nombre de Usuario</label>
                        <input 
                            type="text" 
                            id="username"
                            name="nombre_usuario" 
                            required 
                            placeholder="Ej. juan_perez"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-600 transition duration-300"
                        >
                    </div>
                    
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
                            <a href="<?php echo $routeRegister; ?>" class="text-gray-800 font-semibold hover:underline">
                                Contacte al administrador
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </main>


</body>
</html>