<?php

session_start();
require_once __DIR__ . '/../config/db.php';


$email = trim($_POST['email'] ?? '');
$pwd   = $_POST['pwd'] ?? '';

if ($email === '' || $pwd === '') {
    die('Debes ingresar email y contraseña.');
}


$stmt = $pdo->prepare(
    'SELECT id_usuario, password_hash
       FROM Usuario
      WHERE email = ?'
);
$stmt->execute([$email]);
$usr = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usr || !password_verify($pwd, $usr['password_hash'])) {
    die('Credenciales inválidas.');
}

$_SESSION['id_usuario'] = (int) $usr['id_usuario'];
header('Location: /gescon/src/dashboard.php');
exit;
?>
