<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$nombre      = trim($_POST['nombre']      ?? '');
$email       = trim($_POST['email']       ?? '');
$password    = $_POST['password']         ?? '';
$institucion = trim($_POST['institucion'] ?? '');

if ($nombre === '' || $email === '' || $password === '' || $institucion === '') {
    die('Todos los campos son obligatorios.');
}


$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();


    $stmt = $pdo->prepare("
      INSERT INTO Usuario (nombre, email, password_hash)
      VALUES (?, ?, ?)
    ");
    $stmt->execute([$nombre, $email, $hash]);
    $idUsuario = $pdo->lastInsertId();

    $stmt = $pdo->prepare("
      INSERT INTO Revisor (id_usuario, institucion, fecha_designacion)
      VALUES (?, ?, CURDATE())
    ");
    $stmt->execute([$idUsuario, $institucion]);

    $idRol = $pdo->query("SELECT id_rol FROM Rol WHERE nombre = 'revisor'")->fetchColumn();
    $pdo->prepare("INSERT INTO UsuarioRol (id_usuario, id_rol) VALUES (?, ?)")
        ->execute([$idUsuario, $idRol]);

    $pdo->commit();

    header('Location: /gescon/PHP/router.php?page=revisores');
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    die('Error al guardar: ' . $e->getMessage());
}
