<!DOCTYPE html>
<html>
<head>
    <title>Banco</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Iniciar Sesión - Cajero</h2>
    <form action="index.php?action=login" method="post">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <label>Contraseña:</label>
        <input type="password" name="clave" required>
        <input type="submit" value="Ingresar">
    </form>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
</div>
</body>
</html>