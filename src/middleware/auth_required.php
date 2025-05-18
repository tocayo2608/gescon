<?php
// middleware/auth_required.php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: /gescon/src/auth/login.html");
    exit;
}
