<?php
require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idArt = (int) ($_POST['id_articulo'] ?? 0);
$idRev = (int) ($_POST['id_revisor']  ?? 0);

if (!$idArt || !$idRev) {
    die('Datos incompletos.');
}

/* Evitar duplicados: no asignar dos veces el mismo revisor al mismo artículo */
$existe = $pdo->prepare("
  SELECT COUNT(*) FROM Reseña
  WHERE id_articulo = ? AND id_revisor = ?
");
$existe->execute([$idArt, $idRev]);
if ($existe->fetchColumn() > 0) {
    die('Este revisor ya fue asignado a este artículo.');
}

/* Insertar la asignación */
$stmt = $pdo->prepare("
  INSERT INTO Reseña (id_articulo, id_revisor, fecha_asignacion)
  VALUES (?, ?, CURDATE())
");
$stmt->execute([$idArt, $idRev]);

header('Location: /gescon/src/router.php?page=articulos');
exit;
