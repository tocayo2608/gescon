<?php
/* --------------------------------------------------
   GESCON – Layout base con Bootstrap 5
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/gescon/src/router.php?page=dashboard">GESCON</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=dashboard">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=articulos">Mis artículos</a></li>
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=articulo_crear">Nuevo artículo</a></li>
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=revisores">Revisores</a></li>
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=busqueda">Buscar</a></li>
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=resenas_mias">Mis reseñas</a></li>
                <li class="nav-item"><a class="nav-link" href="/gescon/src/router.php?page=resenas_asignar">Asignar reseñas</a></li>
            </ul>
            <span class="navbar-text">
          <a href="/gescon/src/logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </span>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <?php include $contenido; ?>
</main>
</body>
</html>
