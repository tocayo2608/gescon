<h2>Búsqueda avanzada de artículos</h2>

<form method="get" action="/gescon/PHP/router.php" class="row gy-2 gx-3 align-items-center">
    <input type="hidden" name="page" value="busqueda">

    <div class="col-md">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control"
               value="<?= htmlspecialchars($filtros['titulo'] ?? '') ?>">
    </div>

    <div class="col-md">
        <label class="form-label">Tópico</label>
        <input type="text" name="topico" class="form-control"
               value="<?= htmlspecialchars($filtros['topico'] ?? '') ?>">
    </div>

    <div class="col-md">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="">— Todos —</option>
            <?php foreach ($estados as $e): ?>
                <option value="<?= $e['id_estado'] ?>"
                    <?= ($filtros['estado'] ?? '') == $e['id_estado'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($e['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md">
        <label class="form-label">Autor</label>
        <input type="text" name="autor" class="form-control"
               value="<?= htmlspecialchars($filtros['autor'] ?? '') ?>">
    </div>

    <div class="col-md">
        <label class="form-label">Revisor</label>
        <input type="text" name="revisor" class="form-control"
               value="<?= htmlspecialchars($filtros['revisor'] ?? '') ?>">
    </div>

    <div class="col-md">
        <label class="form-label">Envío desde</label>
        <input type="date" name="desde" class="form-control"
               value="<?= htmlspecialchars($filtros['desde'] ?? '') ?>">
    </div>

    <div class="col-md">
        <label class="form-label">Envío hasta</label>
        <input type="date" name="hasta" class="form-control"
               value="<?= htmlspecialchars($filtros['hasta'] ?? '') ?>">
    </div>

    <div class="col-md-auto align-self-end">
        <button class="btn btn-primary">Buscar</button>
    </div>
</form>

<hr>

<?php if (!isset($resultados)): ?>
    <p>Completa uno o más filtros y presiona “Buscar”.</p>
<?php elseif (empty($resultados)): ?>
    <p>No se encontraron coincidencias.</p>
<?php else: ?>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
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
