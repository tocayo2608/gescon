<?php
/*  GESCON – Inicio de sesión
    Ruta : /src/auth/login.php
--------------------------------------------------------- */
session_start();
require_once __DIR__ . '/../config/db.php';

/* 1. Tomar datos del formulario */
$email = trim($_POST['email'] ?? '');
$pwd   = $_POST['pwd'] ?? '';

if ($email === '' || $pwd === '') {
    die('Debes ingresar email y contraseña.');
}

/* 2. Buscar usuario por email */
$stmt = $pdo->prepare(
    'SELECT id_usuario, password_hash
       FROM Usuario
      WHERE email = ?'
);
$stmt->execute([$email]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);

/* 3. Verificar existencia y contraseña */
if (!$usr || !password_verify($pwd, $usr['password_hash'])) {
    die('Credenciales inválidas.');
}

/* 4. Iniciar sesión y redirigir */
$_SESSION['id_usuario'] = (int) $usr['id_usuario'];
header('Location: /gescon/src/dashboard.php');
exit;
?>
