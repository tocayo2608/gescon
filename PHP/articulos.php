<?php

require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idUsuario = (int) $_SESSION['id_usuario'];
$busqueda  = trim($_GET['q'] ?? '');


$sql = "
  SELECT a.id_articulo,
         a.titulo,
         a.fecha_envio,
         e.nombre AS estado
  FROM   Articulo  a
  JOIN   AutorArt  aa ON aa.id_articulo = a.id_articulo
  JOIN   Estado    e  ON e.id_estado   = a.id_estado
  WHERE  aa.id_usuario = :usr
";
$params = ['usr' => $idUsuario];


if ($busqueda !== '') {
    $sql .= " AND (a.titulo LIKE :q OR a.topicos LIKE :q) ";
    $params['q'] = "%$busqueda%";
}

$sql .= " ORDER BY a.fecha_envio DESC";


$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$titulo    = 'Mis artículos – GESCON';
$contenido = __DIR__ . '/articulos_view.php';
include __DIR__ . '/layout.php';
