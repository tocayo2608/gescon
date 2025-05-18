<?php

require_once __DIR__ . '/middleware/auth_required.php';
require_once __DIR__ . '/config/db.php';

$idAutor = (int) $_SESSION['id_usuario'];
$titulo  = trim($_POST['titulo']  ?? '');
$resumen = trim($_POST['resumen'] ?? '');
$topicos = trim($_POST['topicos'] ?? '');

if ($titulo === '' || $resumen === '') {
    die('Título y resumen son obligatorios.');
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
      INSERT INTO Articulo
        (titulo, fecha_envio, resumen, topicos, autor_contacto, fecha_limite_envio)
      VALUES
        (:t, CURDATE(), :r, :p, :a, DATE_ADD(CURDATE(), INTERVAL 30 DAY))
    ");
    $stmt->execute([
        ':t' => $titulo,
        ':r' => $resumen,
        ':p' => $topicos,
        ':a' => $idAutor
    ]);
    $idArt = (int) $pdo->lastInsertId();

    $pdo->prepare("
      INSERT INTO AutorArt (id_articulo, id_usuario, orden_autor)
      VALUES (:art, :usr, 1)
    ")->execute([':art'=>$idArt, ':usr'=>$idAutor]);

    $pdo->commit();
    header("Location: /gescon/PHP/router.php?page=articulos");
    exit;
} catch (PDOException $e) {
    $pdo->rollBack();
    die('Error al guardar: ' . $e->getMessage());
}
