<h2>Búsqueda avanzada de artículos</h2>

<form method="get" action="/gescon/src/router.php">
    <input type="hidden" name="page" value="busqueda">

    <label>Título:
        <input type="text" name="titulo" value="<?= htmlspecialchars($filtros['titulo'] ?? '') ?>">
    </label>

    <label>Tópico:
        <input type="text" name="topico" value="<?= htmlspecialchars($filtros['topico'] ?? '') ?>">
    </label>

    <label>Estado:
        <select name="estado">
            <option value="">— Todos —</option>
            <?php foreach ($estados as $e): ?>
                <option value="<?= $e['id_estado'] ?>"
                    <?= ($filtros['estado'] ?? '') == $e['id_estado'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Autor:
        <input type="text" name="autor" value="<?= htmlspecialchars($filtros['autor'] ?? '') ?>">
    </label>

    <button type="submit">Buscar</button>
</form>

<hr>

<?php if (!isset($resultados)): ?>
    <p>Completa uno o más filtros y presiona “Buscar”.</p>
<?php elseif (empty($resultados)): ?>
    <p>No se encontraron coincidencias.</p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Tópicos</th>
            <th>Autor contacto</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resultados as $row): ?>
            <tr>
                <td><?= $row['id_articulo'] ?></td>
                <td><?= htmlspecialchars($row['titulo']) ?></td>
                <td><?= htmlspecialchars($row['topicos']) ?></td>
                <td><?= htmlspecialchars($row['contacto']) ?></td>
                <td><?= htmlspecialchars($row['estado']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
