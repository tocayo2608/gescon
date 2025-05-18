<h2>Listado de Revisores</h2>

<p><a href="/gescon/src/router.php?page=revisor_crear">+ Agregar revisor</a></p>

<?php if (empty($revisores)): ?>
    <p>No hay revisores registrados.</p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Institución</th>
            <th>Fecha designación</th>
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
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
