<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: /gescon/PHP/auth/login.html');
    exit;
}