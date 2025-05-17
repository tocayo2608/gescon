<?php
/*  GESCON – Panel básico del usuario
    Ruta : /src/dashboard.php
--------------------------------------------------------- */
session_start();
if (!isset($_SESSION['id_usuario'])) {
    /* No hay sesión → redirigir al login (que crearemos luego) */
    header('Location: /gescon/src/auth/login.html');
    exit;
}

require_once __DIR__ . '/config/db.php';

/* Obtener nombre y roles del usuario */
$idUsuario = (int) $_SESSION['id_usuario'];

/* Nombre */
$stmt = $pdo->prepare('SELECT nombre, email FROM Usuario WHERE id_usuario = ?');
$stmt->execute([$idUsuario]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

/* Roles */
$roles = $pdo->prepare(
    'SELECT r.nombre
       FROM Rol r
       JOIN UsuarioRol ur ON ur.id_rol = r.id_rol
      WHERE ur.id_usuario = ?'
);
$roles->execute([$idUsuario]);
$listaRoles = $roles->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi perfil – GESCON</title>
</head>
<body>
<h2>Bienvenido(a), <?= htmlspecialchars($usuario['nombre']) ?></h2>

<p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>

<p><strong>Roles asignados:</strong>
    <?= htmlspecialchars(implode(', ', $listaRoles)) ?>
</p>

<p>
    <a href="/gescon/src/logout.php">Cerrar sesión</a>
</p>
</body>
</html>
