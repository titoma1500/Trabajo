<!DOCTYPE html>
<html>
<head>
    <title>Realizar transacciones</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Depósitos y retiros</h2>
    <form action="index.php?action=transacciones" method="post">
        <label>Número de cuenta:</label>
        <input type="number" name="id_cuenta" required>
        <label>Tipo de transacción:</label>
        <select name="tipo" required>
            <option value="Deposito">Depósito</option>
            <option value="Retiro">Retiro</option>
        </select>
        <label>Monto:</label>
        <input type="number" step="0.01" name="monto" required>
        <input type="submit" value="Realizar Transacción">
    </form>
    <?php if (isset($mensaje)) echo "<p>" . $mensaje . "</p>"; ?>
    <br>
    <a href="index.php?action=dashboard">Volver a inicio</a>
</div>
</body>
</html>