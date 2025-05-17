<?php
/*  GESCON – Registro de usuario
    Ruta : /src/auth/register.php
--------------------------------------------------------- */
require_once __DIR__ . '/../config/db.php';
session_start();

// 1. Recibir datos del formulario
$nombre = trim($_POST['nombre'] ?? '');
$email  = trim($_POST['email']  ?? '');
$pwd    = $_POST['pwd']        ?? '';
$rol    = (int) ($_POST['rol'] ?? 0);   // 1 = autor, 2 = revisor

// 2. Validaciones mínimas
if ($nombre === '' || $email === '' || $pwd === '' || $rol === 0) {
    die('Faltan campos obligatorios.');
}

// 3. Insertar en la base
try {
    $pdo->beginTransaction();

    // 3a. Tabla Usuario
    $hash = password_hash($pwd, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare(
        'INSERT INTO Usuario (nombre, email, password_hash)
         VALUES (:n, :e, :h)'
    );
    $stmt->execute([':n'=>$nombre, ':e'=>$email, ':h'=>$hash]);
    $idUsuario = (int) $pdo->lastInsertId();

    // 3b. Tabla UsuarioRol
    $stmt = $pdo->prepare(
        'INSERT INTO UsuarioRol (id_usuario, id_rol)
         VALUES (:u, :r)'
    );
    $stmt->execute([':u'=>$idUsuario, ':r'=>$rol]);

    // 3c. Tabla espejo 1:1
    if ($rol === 1) {                 // autor
        $pdo->exec("INSERT INTO Autor(id_usuario) VALUES ($idUsuario)");
    } elseif ($rol === 2) {           // revisor
        $pdo->exec("INSERT INTO Revisor(id_usuario) VALUES ($idUsuario)");
    }

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    // Si el email ya existe, mostrará un mensaje legible
    if ($e->getCode() === '23000') {
        die('El correo ya está registrado.');
    }
    die('Error: ' . $e->getMessage());
}

// 4. Autenticar y redirigir
$_SESSION['id_usuario'] = $idUsuario;
header('Location: /gescon/src/dashboard.php');
exit;
?>
