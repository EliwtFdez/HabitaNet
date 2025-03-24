<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 to-purple-500">
  <form action="controllers/loginController.php" method="POST" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm transform hover:scale-105 transition-transform duration-300">
    <h2 class="text-3xl font-bold mb-6 text-center bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text">Iniciar Sesión</h2>
    
    <p class="text-gray-600 mb-6 text-center">Inicie sesión para administrar su propiedad</p>

    <div class="mb-4">
      <label class="block mb-2 text-gray-700 font-semibold">Correo electrónico:</label>
      <input type="email" name="usuario" required 
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
        placeholder="tu@ejemplo.com">
    </div>

    <div class="mb-4">
      <label class="block mb-2 text-gray-700 font-semibold">Contraseña:</label>
      <input type="password" name="clave" required 
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
        placeholder="Ingrese su contraseña">
    </div>

    <div class="mb-6 text-right">
      <a href="#" class="text-blue-500 hover:text-blue-700 text-sm">¿Olvidaste tu contraseña?</a>
    </div>

    <button type="submit" 
      class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg font-bold hover:from-blue-600 hover:to-purple-700 transform hover:-translate-y-1 transition-all duration-300 shadow-md">
      Entrar
    </button>

    <p class="mt-6 text-center text-gray-600">
      ¿No tienes cuenta? 
      <a href="#" class="text-blue-500 hover:text-blue-700 font-semibold">Regístrate aquí</a>
    </p>
  </form>
</div>
