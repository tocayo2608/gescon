<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idArt = (int) ($_POST['id_articulo'] ?? 0);
$idUsr = (int) $_SESSION['id_usuario'];

$idEliminado = $pdo->query("SELECT id_estado FROM Estado WHERE nombre = 'Eliminado'")->fetchColumn();

$upd = $pdo->prepare("
  UPDATE Articulo
  SET id_estado = :elim
  WHERE id_articulo = :art
    AND autor_contacto = :usr
    AND fecha_limite_envio >= CURDATE()
");
$upd->execute([
    ':elim' => $idEliminado,
    ':art'  => $idArt,
    ':usr'  => $idUsr
]);

header('Location: /gescon/PHP/router.php?page=articulos');
exit;
