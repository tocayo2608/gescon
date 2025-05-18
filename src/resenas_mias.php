<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idRevisor = (int) $_SESSION['id_usuario'];

$stmt = $pdo->prepare("
  SELECT r.id_reseña, a.titulo,
         r.fecha_asignacion, r.fecha_envio,
         r.puntaje
  FROM   Reseña r
  JOIN   Articulo a ON a.id_articulo = r.id_articulo
  WHERE  r.id_revisor = ?
  ORDER BY r.fecha_asignacion DESC
");
$stmt->execute([$idRevisor]);
$misResenas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titulo    = 'Mis Reseñas – GESCON';
$contenido = __DIR__ . '/resenas_mias_view.php';
include __DIR__ . '/layout.php';
