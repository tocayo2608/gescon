<?php

require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';


$idUsuario = (int) $_SESSION['id_usuario'];


$stmt = $pdo->prepare('SELECT nombre, email FROM Usuario WHERE id_usuario = ?');
$stmt->execute([$idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);


$roles = $pdo->prepare(
    'SELECT r.nombre
       FROM Rol r
       JOIN UsuarioRol ur ON ur.id_rol = r.id_rol
      WHERE ur.id_usuario = ?'
);
$roles->execute([$idUsuario]);
$listaRoles = $roles->fetchAll(PDO::FETCH_COLUMN);


$titulo    = 'Mi perfil – GESCON';
$contenido = __DIR__ . '/dashboard_view.php';
include __DIR__ . '/layout.php';
