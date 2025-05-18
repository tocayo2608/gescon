<h2>Eliminar artículo</h2>
<p>¿Seguro que deseas eliminar <strong><?= htmlspecialchars($art['titulo']) ?></strong>?</p>

<form action="/gescon/PHP/articulo_borrar_exec.php" method="post">
    <input type="hidden" name="id_articulo" value="<?= $art['id_articulo'] ?>">
    <button type="submit">Sí, eliminar</button>
    <a href="/gescon/PHP/router.php?page=articulos">Cancelar</a>
</form>
