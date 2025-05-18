
<h2>Bienvenido(a), <?= htmlspecialchars($usuario['nombre']) ?></h2>

<p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']) ?></p>

<p><strong>Roles asignados:</strong>
    <?= htmlspecialchars(implode(', ', $listaRoles)) ?>
</p>
