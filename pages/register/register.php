<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-400 to-purple-500">
  <form action="Controllers/registerController.php" method="POST" class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm transform hover:scale-105 transition-transform duration-300">
    <h2 class="text-3xl font-bold mb-6 text-center bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text">
      Registro de Usuario
    </h2>
    
    <div class="mb-4">
      <label for="usuario" class="block mb-2 text-gray-700 font-semibold">Usuario:</label>
      <input type="text" name="usuario" id="usuario" required 
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
        placeholder="Ingrese su usuario">
    </div>

    <div class="mb-6">
      <label for="clave" class="block mb-2 text-gray-700 font-semibold">Contraseña:</label>
      <input type="password" name="clave" id="clave" required 
        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
        placeholder="Ingrese su contraseña">
    </div>

    <button type="submit" 
      class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-lg font-bold hover:from-blue-600 hover:to-purple-700 transform hover:-translate-y-1 transition-all duration-300 shadow-md">
      Registrarse
    </button>
  </form>
</div>

<style>
/* Custom animations and transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
.duration-300 {
    transition-duration: 300ms;
}
.transform {
    transform: translateZ(0);
}
.hover\:scale-105:hover {
    transform: scale(1.05);
}
.hover\:-translate-y-1:hover {
    transform: translateY(-0.25rem);
}
</style>
