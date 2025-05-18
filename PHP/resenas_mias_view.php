<h2>Mis reseñas asignadas</h2>

<?php if (empty($misResenas)): ?>
    <p>No tienes reseñas asignadas.</p>
<?php else: ?>
    <table border="1" cellpadding="6">
        <thead>
        <tr>
            <th>Artículo</th>
            <th>Asignación</th>
            <th>Entregada</th>
            <th>Puntaje</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($misResenas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['titulo']) ?></td>
                <td><?= $r['fecha_asignacion'] ?></td>
                <td><?= $r['fecha_envio'] ?: '—' ?></td>
                <td><?= $r['puntaje'] ?? '—' ?></td>
                <td>
                    <?php if ($r['fecha_envio']): ?>
                        —
                    <?php else: ?>
                        <a href="/gescon/PHP/router.php?page=resena_entregar&id=<?= $r['id_reseña'] ?>">Entregar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
