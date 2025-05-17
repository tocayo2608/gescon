<?php
/*  GESCON – Conexión PDO
    Ruta : /src/config/db.php
--------------------------------------------------------- */

$host = '127.0.0.1';
$db   = 'gescon';
$user = 'root';
$pass = '';           // ← pon TU_CONTRASEÑA si configuraste una
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO(
        $dsn,
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
