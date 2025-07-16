<!DOCTYPE html>
<html>
<head>
    <title>Consultar cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Consulta por cédula</h2>
    <form action="index.php" method="get">
        <input type="hidden" name="action" value="consultarCliente">
        <label>Cédula del cliente:</label>
        <input type="text" name="cedula" required value="<?php echo $_GET['cedula'] ?? ''; ?>">
        <input type="submit" value="Consultar">
    </form>
    <hr>
    <?php if (isset($cliente)): ?>
        <h3>Información del cliente</h3>
        <p><strong>Nombre:</strong> <?php echo $cliente['nombre']; ?></p>
        <p><strong>Número de cuenta:</strong> <?php echo $cliente['id_cuenta']; ?></p>
        
        <h4>Historial de transacciones</h4>
        <?php if (!empty($transacciones)): ?>
            <table>
                <tr><th>Tipo</th><th>Monto</th><th>Fecha</th></tr>
                <?php foreach ($transacciones as $t): ?>
                <tr>
                    <td><?php echo $t['tipo']; ?></td>
                    <td><?php echo $t['monto']; ?></td>
                    <td><?php echo $t['fecha']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No hay transacciones para esta cuenta.</p>
        <?php endif; ?>
        <h3>Saldo Total: S/. <?php echo number_format($saldo, 2); ?></h3>
    <?php elseif (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <br>
    <a href="index.php?action=dashboard">Volver a inicio</a>
</div>
</body>
</html>