<h2>Entregar reseña</h2>

<form method="post" action="/gescon/src/resena_entregar_exec.php">
    <input type="hidden" name="id_reseña" value="<?= $r['id_reseña'] ?>">

    <p><strong>Artículo:</strong> <?= htmlspecialchars($r['titulo']) ?></p>

    <label>Decisión:<br>
        <select name="decision" required>
            <option value="">— Seleccionar —</option>
            <option value="Aceptado">Aceptado</option>
            <option value="Revisión menor">Revisión menor</option>
            <option value="Revisión mayor">Revisión mayor</option>
        </select>
    </label><br><br>

    <label>Comentario:<br>
        <textarea name="comentario" required rows="5" style="width: 60%"></textarea>
    </label><br><br>

    <label>Puntaje (1–5):<br>
        <input type="number" name="puntaje" min="1" max="5" required>
    </label><br><br>

    <button type="submit">Enviar reseña</button>
</form>
