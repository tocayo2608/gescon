<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$id = (int) ($_POST['id_reseña'] ?? 0);
$usr = (int) $_SESSION['id_usuario'];

$puntaje   = (int) $_POST['puntaje'] ?? 0;
$comentario = trim($_POST['comentario'] ?? '');
$decision   = trim($_POST['decision'] ?? '');

if (!$id || $puntaje < 1 || $puntaje > 5 || $comentario === '' || $decision === '') {
    exit('Todos los campos son obligatorios.');
}

$upd = $pdo->prepare("
  UPDATE Reseña
  SET fecha_envio = CURDATE(),
      puntaje = :p,
      comentario = :c,
      decision = :d
  WHERE id_reseña = :id
    AND id_revisor = :usr
    AND fecha_envio IS NULL
");
$upd->execute([
    ':p' => $puntaje,
    ':c' => $comentario,
    ':d' => $decision,
    ':id' => $id,
    ':usr' => $usr
]);

header('Location: /gescon/src/router.php?page=resenas_mias');
exit;
