<h2>Listado de Revisores</h2>

<p>
    <a href="/gescon/PHP/router.php?page=revisor_crear" class="btn btn-sm btn-success">
        + Agregar revisor
    </a>
</p>

<?php if (empty($revisores)): ?>
    <p>No hay revisores registrados.</p>
<?php else: ?>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Institución</th>
            <th>Fecha designación</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($revisores as $r): ?>
            <tr>
                <td><?= $r['id_usuario'] ?></td>
                <td><?= htmlspecialchars($r['nombre']) ?></td>
                <td><?= htmlspecialchars($r['email']) ?></td>
                <td><?= htmlspecialchars($r['institucion']) ?></td>
                <td><?= $r['fecha_designacion'] ?></td>
                <td>
                    <a href="/gescon/PHP/router.php?page=revisor_editar&id=<?= $r['id_usuario'] ?>"
                       class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="/gescon/PHP/router.php?page=revisor_eliminar&id=<?= $r['id_usuario'] ?>"
                       class="btn btn-sm btn-outline-danger"
                       onclick="return confirm('¿Eliminar revisor?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
