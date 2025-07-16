<!DOCTYPE html>
<html>
<head>
    <title>Registrar cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Registro de nuevo cliente</h2>
    <form action="index.php?action=registrarCliente" method="post">
        <label>Cédula:</label>
        <input type="text" name="cedula" required>
        <label>Nombre completo:</label>
        <input type="text" name="nombre" required>
        <input type="submit" value="Registrar Cliente">
    </form>
    <?php if (isset($mensaje)) echo "<p class='success'>$mensaje</p>"; ?>
    <br>
    <a href="index.php?action=dashboard">Volver a inicio</a>
</div>
</body>
</html>