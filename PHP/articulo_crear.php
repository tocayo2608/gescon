<?php

require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';


$esAutor = $pdo->prepare("
  SELECT 1
  FROM   UsuarioRol ur
  JOIN   Rol r ON r.id_rol = ur.id_rol
  WHERE  ur.id_usuario = ? AND r.nombre = 'autor'
");
$esAutor->execute([$_SESSION['id_usuario']]);
if (!$esAutor->fetchColumn()) {
    http_response_code(403);
    exit('Acceso permitido sólo a autores.');
}

$titulo    = 'Nuevo artículo – GESCON';
$contenido = __DIR__ . '/articulo_crear_view.php';
include __DIR__ . '/layout.php';
