<?php
class ClienteModel {
    static public function mdlVerificarCajero($usuario, $clave) {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM cajeros WHERE usuario = :usuario AND clave = :clave");
        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->bindParam(":clave", $clave, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function mdlRegistrarCliente($cedula, $nombre) {
        $db = Conexion::conectar();
        $stmt_check = $db->prepare("SELECT cedula FROM clientes WHERE cedula = :cedula");
        $stmt_check->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->fetch()) {
            return "error_existe";
        }
        
        try {
            $db->beginTransaction();
            $stmt_cliente = $db->prepare("INSERT INTO clientes (cedula, nombre) VALUES (:cedula, :nombre)");
            $stmt_cliente->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            $stmt_cliente->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt_cliente->execute();
            
            $stmt_cuenta = $db->prepare("INSERT INTO cuentas (cedula_cliente) VALUES (:cedula)");
            $stmt_cuenta->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            $stmt_cuenta->execute();
            
            $db->commit();
            return "ok";
        } catch (Exception $e) {
            $db->rollBack();
            return "error_transaccion";
        }
    }

    static public function mdlBuscarClientePorCedula($cedula) {
        $stmt = Conexion::conectar()->prepare(
            "SELECT c.nombre, cu.id_cuenta FROM clientes c 
             JOIN cuentas cu ON c.cedula = cu.cedula_cliente 
             WHERE c.cedula = :cedula"
        );
        $stmt->bindParam(":cedula", $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}