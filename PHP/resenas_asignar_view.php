<h2>Asignar Reseñas</h2>

<form method="post" action="/gescon/PHP/resenas_asignar_exec.php">
    <label>Artículo:<br>
        <select name="id_articulo" required>
            <option value="">— Seleccionar —</option>
            <?php foreach ($articulos as $a): ?>
                <option value="<?= $a['id_articulo'] ?>">
                    <?= htmlspecialchars($a['titulo']) ?> (<?= $a['estado'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Revisor:<br>
        <select name="id_revisor" required>
            <option value="">— Seleccionar —</option>
            <?php foreach ($revisores as $r): ?>
                <option value="<?= $r['id_usuario'] ?>">
                    <?= htmlspecialchars($r['nombre']) ?> (<?= $r['email'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <button type="submit">Asignar revisor</button>
</form>
