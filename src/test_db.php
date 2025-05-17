<?php
require_once __DIR__ . '/config/db.php';
echo 'Conexión OK – base: ' . $pdo->query('select database()')->fetchColumn();
?>
