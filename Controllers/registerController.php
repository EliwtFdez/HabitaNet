<?php
$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';

// Aquí podrías guardarlo en una BD, pero por ahora solo simulamos
echo "Usuario '$usuario' registrado correctamente.<br>";
echo "<a href='../../index.php?page=login'>Ir al login</a>";
