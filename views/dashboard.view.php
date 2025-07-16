<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Bienvenido, <?php echo $_SESSION['cajero_usuario']; ?></h2>
    <p>Seleccione una operación:</p>
    <nav>
        <a href="index.php?action=registrarCliente">Registrar cliente</a>
        <a href="index.php?action=transacciones">Realizar transacción</a>
        <a href="index.php?action=consultarCliente">Consultar cliente</a>
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</div>
</body>
</html>