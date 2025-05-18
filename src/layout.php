<?php
/* --------------------------------------------------
   GESCON – Layout base
   Uso:
       $titulo   = 'Título de página';
       $contenido = __DIR__ . '/mi_pagina_contenido.php';
       include __DIR__ . '/layout.php';
-------------------------------------------------- */
require_once __DIR__ . '/middleware/auth_required.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'GESCON') ?></title>
    <link rel="stylesheet" href="/gescon/assets/estilo.css">
</head>
<body>
<header>
    <nav>
        <a href="/gescon/src/router.php?page=dashboard">Inicio</a> |
        <a href="/gescon/src/router.php?page=articulos">Mis artículos</a> |
        <a href="/gescon/src/router.php?page=articulo_crear">Nuevo artículo</a> |
        <a href="/gescon/src/router.php?page=revisores">Revisores</a> |
        <a href="/gescon/src/logout.php">Cerrar sesión</a>

    </nav>

    <hr>
</header>

<main>
    <?php include $contenido; ?>
</main>
</body>
</html>
