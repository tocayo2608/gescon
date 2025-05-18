<?php
/*  GESCON – Router mínimo (versión segura)
    Uso: router.php?page=dashboard
--------------------------------------------------------- */
require_once __DIR__ . '/middleware/auth_required.php';

$page = $_GET['page'] ?? 'dashboard';

/* Mapa de páginas permitidas */
$routes = [
    'dashboard' => __DIR__ . '/dashboard.php',
    'articulos' => __DIR__ . '/articulos.php',   // todavía no existe
    'articulo_crear' => __DIR__ . '/articulo_crear.php',
    'articulo_borrar'      => __DIR__ . '/articulo_borrar.php',
    'articulo_borrar_exec' => __DIR__ . '/articulo_borrar_exec.php',
    'revisores' => __DIR__ . '/revisores.php',
    'revisor_crear' => __DIR__ . '/revisor_crear.php',
    'resenas_asignar'      => __DIR__ . '/resenas_asignar.php',
    'resenas_asignar_exec' => __DIR__ . '/resenas_asignar_exec.php',
    'resenas_mias'         => __DIR__ . '/resenas_mias.php',
    'resena_entregar'      => __DIR__ . '/resena_entregar.php',
    'resena_entregar_exec' => __DIR__ . '/resena_entregar_exec.php',
    'busqueda' => __DIR__ . '/busqueda.php',






];

/* Si existe y el archivo está presente, lo incluimos */
if (isset($routes[$page]) && file_exists($routes[$page])) {
    require $routes[$page];
} else {
    /* 404 amigable */
    http_response_code(404);
    echo "<h2>Página no encontrada</h2>";
}
