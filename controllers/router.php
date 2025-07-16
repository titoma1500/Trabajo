<?php
session_start();
require_once 'models/conexion.php';
require_once 'models/cliente.model.php';
require_once 'models/transaccion.model.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];
            $cajero = ClienteModel::mdlVerificarCajero($usuario, $clave);
            if ($cajero) {
                $_SESSION['cajero_usuario'] = $cajero['usuario'];
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                require 'views/login.view.php';
            }
        } else {
            require 'views/login.view.php';
        }
        break;

    case 'dashboard':
        if (!isset($_SESSION['cajero_usuario'])) header("Location: index.php?action=login");
        require 'views/dashboard.view.php';
        break;

    case 'registrarCliente':
        if (!isset($_SESSION['cajero_usuario'])) header("Location: index.php?action=login");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $resultado = ClienteModel::mdlRegistrarCliente($cedula, $nombre);
            $mensaje = ($resultado == "ok") ? "Cliente y cuenta creados exitosamente." : "Error: El cliente ya existe.";
        }
        require 'views/registrar_cliente.view.php';
        break;

    case 'transacciones':
        if (!isset($_SESSION['cajero_usuario'])) header("Location: index.php?action=login");
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_cuenta = $_POST['id_cuenta'];
            $tipo = $_POST['tipo'];
            $monto = $_POST['monto'];
            $resultado = TransaccionModel::mdlCrearTransaccion($id_cuenta, $tipo, $monto);
            $mensaje = $resultado;
        }
        require 'views/transacciones.view.php';
        break;
        
    case 'consultarCliente':
        if (!isset($_SESSION['cajero_usuario'])) header("Location: index.php?action=login");
        if (isset($_GET['cedula'])) {
            $cedula = $_GET['cedula'];
            $cliente = ClienteModel::mdlBuscarClientePorCedula($cedula);
            if ($cliente) {
                $transacciones = TransaccionModel::mdlObtenerTransacciones($cliente['id_cuenta']);
                $saldo = TransaccionModel::mdlCalcularSaldo($cliente['id_cuenta']);
            } else {
                $error = "No se encontró cliente con la cédula proporcionada.";
            }
        }
        require 'views/consultar_cliente.view.php';
        break;

    default:
        require 'views/login.view.php';
        break;
}