
<h2>Crear nuevo artículo</h2>

<form action="/gescon/src/articulo_guardar.php" method="post">
    <label>Título:<br>
        <input type="text" name="titulo" required style="width: 60%">
    </label><br><br>

    <label>Resumen:<br>
        <textarea name="resumen" required rows="6" style="width: 60%"></textarea>
    </label><br><br>

    <label>Tópicos (separados por coma):<br>
        <input type="text" name="topicos" style="width: 60%">
    </label><br><br>

    <button type="submit">Enviar artículo</button>
</form>
