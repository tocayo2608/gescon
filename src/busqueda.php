<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

/* Filtros GET */
$filtros = [
    'titulo' => trim($_GET['titulo'] ?? ''),
    'topico' => trim($_GET['topico'] ?? ''),
    'estado' => trim($_GET['estado'] ?? ''),
    'autor'  => trim($_GET['autor'] ?? ''),
];

/* Obtener todos los estados disponibles */
$estados = $pdo->query("SELECT id_estado, nombre FROM Estado ORDER BY orden_visual")->fetchAll();

/* Si no hay filtros definidos, no hacer la búsqueda aún */
$hayBusqueda = $filtros['titulo'] || $filtros['topico'] || $filtros['estado'] || $filtros['autor'];
$resultados = null;

if ($hayBusqueda) {
    $sql = "
      SELECT a.id_articulo, a.titulo, a.topicos,
             CONCAT(u.nombre, ' <', u.email, '>') AS contacto,
             e.nombre AS estado
      FROM   Articulo a
      JOIN   Usuario u ON u.id_usuario = a.autor_contacto
      JOIN   Estado  e ON e.id_estado = a.id_estado
      WHERE  1 = 1
    ";

    $params = [];

    if ($filtros['titulo']) {
        $sql .= " AND a.titulo LIKE :titulo";
        $params[':titulo'] = '%' . $filtros['titulo'] . '%';
    }

    if ($filtros['topico']) {
        $sql .= " AND a.topicos LIKE :topico";
        $params[':topico'] = '%' . $filtros['topico'] . '%';
    }

    if ($filtros['estado']) {
        $sql .= " AND a.id_estado = :estado";
        $params[':estado'] = $filtros['estado'];
    }

    if ($filtros['autor']) {
        $sql .= " AND (u.nombre LIKE :autor OR u.email LIKE :autor)";
        $params[':autor'] = '%' . $filtros['autor'] . '%';
    }

    $sql .= " ORDER BY a.fecha_envio DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* Renderizar */
$titulo    = 'Búsqueda avanzada – GESCON';
$contenido = __DIR__ . '/busqueda_view.php';
include __DIR__ . '/layout.php';
