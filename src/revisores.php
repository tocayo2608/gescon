<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';


$sql = "
  SELECT u.id_usuario, u.nombre, u.email,
         r.institucion, r.fecha_designacion
  FROM   Revisor r
  JOIN   Usuario u ON u.id_usuario = r.id_usuario
  ORDER BY u.nombre ASC
";

$revisores = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);


$titulo    = 'Revisores – GESCON';
$contenido = __DIR__ . '/revisores_view.php';
include __DIR__ . '/layout.php';
