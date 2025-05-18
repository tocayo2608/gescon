<?php
/* GESCON – Registro simple de usuario */
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre && $email && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $pdo->beginTransaction();

            // Insertar en Usuario
            $stmt = $pdo->prepare("
              INSERT INTO Usuario (nombre, email, password_hash)
              VALUES (?, ?, ?)
            ");
            $stmt->execute([$nombre, $email, $hash]);
            $idUsuario = $pdo->lastInsertId();

            // Rol por defecto: autor
            $idRol = $pdo->query("SELECT id_rol FROM Rol WHERE nombre = 'autor'")->fetchColumn();
            $pdo->prepare("INSERT INTO UsuarioRol (id_usuario, id_rol) VALUES (?, ?)")
                ->execute([$idUsuario, $idRol]);

            // Crear fila en Autor
            $pdo->prepare("INSERT INTO Autor (id_usuario, afiliacion) VALUES (?, 'Afiliación por defecto')")
                ->execute([$idUsuario]);

            $pdo->commit();
            header("Location: login.html");
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            die("Error al registrar: " . $e->getMessage());
        }
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse – GESCON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
<div class="card shadow p-4" style="min-width: 380px;">
    <h4 class="text-center mb-3">GESCON – Registro</h4>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
    </form>

    <hr>
    <div class="text-center">
        <p class="mb-2">¿Ya tienes una cuenta?</p>
        <a href="/gescon/src/auth/login.html" class="btn btn-outline-secondary w-100">Iniciar sesión</a>
    </div>
</div>
</body>
</html>
