<?php
// PHP/auth/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = '';

// 1. Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare(
            'SELECT id_usuario, nombre, password_hash
               FROM Usuario
              WHERE email = ?'
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Autenticación correcta
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre']     = $user['nombre'];

            header('Location: /gescon/PHP/index.php');
            exit;
        }
    }
    $error = 'Correo o contraseña incorrectos';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión – GESCON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="card shadow p-4" style="min-width: 340px;">
    <h4 class="text-center mb-3">GESCON – Iniciar sesión</h4>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label" for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" required class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Contraseña</label>
            <input type="password" name="password" id="password" required class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>

    <hr>
    <div class="text-center">
        <p class="mb-2">¿No tienes una cuenta?</p>
        <a href="/gescon/PHP/auth/register.php" class="btn btn-outline-secondary w-100">Registrarse</a>
    </div>
</div>
</body>
</html>
