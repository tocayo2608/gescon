<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';


$articulos = $pdo->query("
  SELECT a.id_articulo, a.titulo, e.nombre AS estado
  FROM   Articulo a
  JOIN   Estado e ON e.id_estado = a.id_estado
  WHERE  e.nombre IN ('Enviado', 'En revisión')
  ORDER BY a.fecha_envio DESC
")->fetchAll(PDO::FETCH_ASSOC);


$revisores = $pdo->query("
  SELECT u.id_usuario, u.nombre, u.email
  FROM   Revisor r
  JOIN   Usuario u ON u.id_usuario = r.id_usuario
  ORDER BY u.nombre ASC
")->fetchAll(PDO::FETCH_ASSOC);

$titulo    = 'Asignar Reseña – GESCON';
$contenido = __DIR__ . '/resenas_asignar_view.php';
include __DIR__ . '/layout.php';
