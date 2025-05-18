<h2>Editar revisor</h2>

<form action="/gescon/src/revisor_actualizar.php" method="post">
    <input type="hidden" name="id" value="<?= $rev['id_usuario'] ?>">

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($rev['nombre']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($rev['email']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Institución</label>
        <input type="text" name="institucion" value="<?= htmlspecialchars($rev['institucion']) ?>" class="form-control" required>
    </div>

    <button class="btn btn-primary">Guardar cambios</button>
</form>
