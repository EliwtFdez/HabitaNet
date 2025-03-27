<?php
// Initialize variables with default values
$Error = isset($Error) ? $Error : "Error 404";
$Mensaje = isset($Mensaje) ? $Mensaje : "Página no encontrada";
$Regresar = isset($Regresar) ? $Regresar : "";
?>
 
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <main class="w-full col-11 max-w-11xl">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden mx-auto">
            <div class="bg-gray-800 p-6 text-center justify-center">
                <h1 class="text-2xl font-bold text-white"><?= $Error ?></h1>
                <p class="text-gray-300 mt-2"><?= $Mensaje ?></p>
            </div>
            
            <div class="p-8 text-center">
                <div class="relative inline-block mb-6">
                    <img
                        class="select-none border-2 border-gray-300"
                        src="assets/img/Alto.png"
                        alt="Error Icon">
                </div>
                
                <a href="<?= $Regresar ?>" 
                    class="inline-block w-40 px-6 py-3 bg-gray-800 text-white rounded-lg font-semibold hover:bg-gray-700 transition duration-300">
                    Regresar
                </a>
            </div>
        </div>
    </main>
</body>
</html>
