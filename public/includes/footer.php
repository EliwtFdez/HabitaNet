<?php
// Change the image path to use absolute path from root
$routeImages = '/HabitaNet/public/assets/img/Logo.png';
?>

<footer class="w-full bg-gray-900 text-white">
  <div class="max-w-7xl mx-auto px-8 py-12 grid grid-cols-1 md:grid-cols-3 gap-12">
    <!-- Logo -->
    <div class="flex flex-col items-center md:items-start space-y-4">
      <div class="flex items-center space-x-4">
        <img src="<?php echo $routeImages; ?>" alt="Logo" class="w-12 h-12 hover:opacity-80 transition-opacity">
        <span class="text-lg font-medium">Sistema de gestión residencial</span>
      </div>
      <p class="text-sm text-gray-400 text-center md:text-left">Simplificando la gestión de su comunidad residencial</p>
    </div>

    <!-- Horario -->
    <div class="text-center md:text-left">
      <h3 class="text-xl font-semibold mb-4 text-gray-200">Horario de Atención</h3>
      <div class="space-y-2">
        <p class="text-sm text-gray-300 hover:text-white transition-colors">Lunes a viernes: 9:00 AM - 6:00 PM</p>
        <p class="text-sm text-gray-300 hover:text-white transition-colors">Fin de semana: 10:00 AM - 6:00 PM</p>
      </div>
    </div>

    <!-- Contacto -->
    <div class="text-center md:text-left">
      <h3 class="text-xl font-semibold mb-4 text-gray-200">Contacto</h3>
      <div class="space-y-2">
        <p class="text-sm text-gray-300 hover:text-white transition-colors">
          <i class="fas fa-phone mr-2"></i>+52 2713020960
        </p>
        <p class="text-sm text-gray-300 hover:text-white transition-colors">
          <i class="fas fa-envelope mr-2"></i>EliwtRosales@habitanet.com
        </p>
      </div>
    </div>
  </div>

  <div class="text-center text-sm text-gray-400 py-6 border-t border-gray-800 mt-8">
    <p>© 2025 Team Grapes. Todos los derechos reservados.</p>
  </div>
</footer>