<!DOCTYPE html>
<html lang="es">

head>
    <meta charset="utf-8">
    <base href="<?= isset($Base) ? $Base : '.'; ?>/" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HabitaNet</title>
    
    <!-- Fuentes y Tailwind -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Estilos personalizados si existen -->
    <?php if (isset($Styles)) : ?>
        <?php foreach ($Styles as $style): ?>
            <link rel="stylesheet" href="<?= $style; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    
    <link rel="stylesheet" href="assets/css/Attendify.css">

    <!-- Scripts si existen -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    <?php if (isset($Scripts)) : ?>
        <?php foreach ($Scripts as $script): ?>
            <script src="<?= $script; ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body>

    <?= $Body; ?>

</body>
<?php include ('includes/footer.php') ?>
</html>
