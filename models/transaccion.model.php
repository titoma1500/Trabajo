<?php
class TransaccionModel {
    static public function mdlCrearTransaccion($id_cuenta, $tipo, $monto) {
        if ($tipo === 'Retiro') {
            $saldo_actual = self::mdlCalcularSaldo($id_cuenta);
            if ($monto > $saldo_actual) {
                return "Error: Saldo insuficiente para realizar el retiro.";
            }
        }
        $stmt = Conexion::conectar()->prepare("INSERT INTO transacciones (id_cuenta, tipo, monto) VALUES (:id_cuenta, :tipo, :monto)");
        $stmt->bindParam(":id_cuenta", $id_cuenta, PDO::PARAM_INT);
        $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindParam(":monto", $monto, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return ucfirst($tipo) . " realizado exitosamente.";
        }
        return "Error al procesar la transacción.";
    }

    static public function mdlObtenerTransacciones($id_cuenta) {
        $stmt = Conexion::conectar()->prepare("SELECT tipo, monto, fecha FROM transacciones WHERE id_cuenta = :id_cuenta ORDER BY fecha DESC");
        $stmt->bindParam(":id_cuenta", $id_cuenta, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlCalcularSaldo($id_cuenta) {
        $db = Conexion::conectar();
        $stmt_deposito = $db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM transacciones WHERE id_cuenta = :id_cuenta AND tipo = 'Deposito'");
        $stmt_deposito->bindParam(":id_cuenta", $id_cuenta, PDO::PARAM_INT);
        $stmt_deposito->execute();
        $depositos = $stmt_deposito->fetchColumn();

        $stmt_retiro = $db->prepare("SELECT COALESCE(SUM(monto), 0) as total FROM transacciones WHERE id_cuenta = :id_cuenta AND tipo = 'Retiro'");
        $stmt_retiro->bindParam(":id_cuenta", $id_cuenta, PDO::PARAM_INT);
        $stmt_retiro->execute();
        $retiros = $stmt_retiro->fetchColumn();
        
        return $depositos - $retiros;
    }
}