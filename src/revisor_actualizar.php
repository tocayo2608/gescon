<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$id          = (int) ($_POST['id'] ?? 0);
$nombre      = trim($_POST['nombre'] ?? '');
$email       = trim($_POST['email']  ?? '');
$institucion = trim($_POST['institucion'] ?? '');

if (!$id || !$nombre || !$email || !$institucion) { exit('Datos incompletos'); }

$pdo->beginTransaction();

$pdo->prepare("UPDATE Usuario SET nombre=?, email=? WHERE id_usuario=?")
    ->execute([$nombre, $email, $id]);

$pdo->prepare("UPDATE Revisor SET institucion=? WHERE id_usuario=?")
    ->execute([$institucion, $id]);

$pdo->commit();
header('Location: /gescon/src/router.php?page=revisores');
exit;
