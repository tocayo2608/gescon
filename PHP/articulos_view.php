
<h2>Mis artículos</h2>
<form method="get" action="/gescon/PHP/router.php">
    <input type="hidden" name="page" value="articulos">
    <label>Buscar:
        <input type="text" name="q" value="<?= htmlspecialchars($busqueda ?? '') ?>">
    </label>
    <button type="submit">Filtrar</button>
    <?php if (!empty($busqueda)): ?>
        <a href="/gescon/PHP/router.php?page=articulos">Limpiar</a>
    <?php endif; ?>
</form>
<br>

<?php if (empty($articulos)): ?>
    <p>No tienes artículos registrados.</p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Fecha envío</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articulos as $art): ?>
            <tr>
                <td><?= $art['id_articulo'] ?></td>


                <td>
                    <a href="/gescon/PHP/router.php?page=articulo_editar&id=<?= $art['id_articulo'] ?>">
                        <?= htmlspecialchars($art['titulo']) ?>
                    </a>
                </td>

                <td><?= $art['fecha_envio'] ?></td>
                <td><?= htmlspecialchars($art['estado']) ?></td>

                <td>
                    <?php if ($art['estado'] !== 'Eliminado'): ?>
                        <a href="/gescon/PHP/router.php?page=articulo_editar&id=<?= $art['id_articulo'] ?>">Editar</a>
                        |
                        <a href="/gescon/PHP/router.php?page=articulo_borrar&id=<?= $art['id_articulo'] ?>"
                           onclick="return confirm('¿Deseas eliminar este artículo?');">
                            Eliminar
                        </a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
