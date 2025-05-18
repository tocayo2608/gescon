<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$id = (int) ($_GET['id'] ?? 0);
$rev = $pdo->prepare("
  SELECT u.id_usuario, u.nombre, u.email, r.institucion
  FROM   Revisor r
  JOIN   Usuario u ON u.id_usuario = r.id_usuario
  WHERE  r.id_usuario = ?
");
$rev->execute([$id]);
$rev = $rev->fetch(PDO::FETCH_ASSOC);
if (!$rev) { exit('Revisor no encontrado'); }

$titulo    = 'Editar Revisor – GESCON';
$contenido = __DIR__ . '/revisor_editar_view.php';
include __DIR__ . '/layout.php';
