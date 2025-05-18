<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$id = (int) ($_GET['id'] ?? 0);


$has = $pdo->prepare("SELECT COUNT(*) FROM Reseña WHERE id_revisor = ?");
$has->execute([$id]);
if ($has->fetchColumn() > 0) {
    exit('No se puede eliminar: revisor con reseñas asignadas.');
}


$pdo->beginTransaction();
$pdo->prepare("DELETE FROM Revisor WHERE id_usuario = ?")->execute([$id]);
$pdo->prepare("DELETE FROM UsuarioRol WHERE id_usuario = ? AND id_rol = (SELECT id_rol FROM Rol WHERE nombre='revisor')")->execute([$id]);
$pdo->commit();

header('Location: /gescon/PHP/router.php?page=revisores');
exit;
