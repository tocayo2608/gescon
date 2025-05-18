<h2>Crear nuevo revisor</h2>

<form method="post" action="/gescon/PHP/revisor_guardar.php">
    <label>Nombre:<br>
        <input type="text" name="nombre" required>
    </label><br><br>

    <label>Email:<br>
        <input type="email" name="email" required>
    </label><br><br>

    <label>Contraseña:<br>
        <input type="password" name="password" required>
    </label><br><br>

    <label>Institución:<br>
        <input type="text" name="institucion" required>
    </label><br><br>

    <button type="submit">Crear revisor</button>
</form>
