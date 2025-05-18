<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$id = (int) ($_GET['id'] ?? 0);

/* Verificar si tiene reseñas asignadas */
$has = $pdo->prepare("SELECT COUNT(*) FROM Reseña WHERE id_revisor = ?");
$has->execute([$id]);
if ($has->fetchColumn() > 0) {
    exit('No se puede eliminar: revisor con reseñas asignadas.');
}

/* Eliminar de Revisor y UsuarioRol; mantener Usuario por auditoría (o borrado físico si se desea) */
$pdo->beginTransaction();
$pdo->prepare("DELETE FROM Revisor WHERE id_usuario = ?")->execute([$id]);
$pdo->prepare("DELETE FROM UsuarioRol WHERE id_usuario = ? AND id_rol = (SELECT id_rol FROM Rol WHERE nombre='revisor')")->execute([$id]);
$pdo->commit();

header('Location: /gescon/src/router.php?page=revisores');
exit;
