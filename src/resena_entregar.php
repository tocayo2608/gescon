<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idResena = (int) ($_GET['id'] ?? 0);
$idUsr    = (int) $_SESSION['id_usuario'];

$stmt = $pdo->prepare("
  SELECT r.*, a.titulo
  FROM   Reseña r
  JOIN   Articulo a ON a.id_articulo = r.id_articulo
  WHERE  r.id_reseña = ? AND r.id_revisor = ? AND r.fecha_envio IS NULL
");
$stmt->execute([$idResena, $idUsr]);
$r = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$r) {
    exit('No tienes permiso para esta acción.');
}

$titulo    = 'Entregar reseña – GESCON';
$contenido = __DIR__ . '/resena_entregar_view.php';
include __DIR__ . '/layout.php';
