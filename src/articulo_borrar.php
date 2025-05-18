<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idArt = (int) ($_GET['id'] ?? 0);
$idUsr = (int) $_SESSION['id_usuario'];

$stmt = $pdo->prepare("
  SELECT a.id_articulo, a.titulo, DATEDIFF(a.fecha_limite_envio, CURDATE()) AS dias
  FROM   Articulo a
  WHERE  a.id_articulo = ? AND a.autor_contacto = ?
");
$stmt->execute([$idArt, $idUsr]);
$art = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$art || $art['dias'] < 0) {
    exit('No autorizado o plazo vencido.');
}

$titulo    = 'Confirmar eliminación – GESCON';
$contenido = __DIR__ . '/articulo_borrar_view.php';
include __DIR__ . '/layout.php';
