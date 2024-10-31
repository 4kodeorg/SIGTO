<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/modelo/Session.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/Database.php';

class SessionController extends Database {
    public function createSesion($email) {
        $sessionCliente = new Session();

        $sessionCliente->setEmail($email);
        $sessionCliente->setFechaInit(date('Y-m-j H:i:s'));
        try {
            return $this->createClienteSession($sessionCliente);
        } catch (Exception $e) {
            throw new Exception ("Error ".$e->getMessage());
        }
    }
    public function createClienteSession($cliente) {
        $logginQuery = "INSERT INTO sesionCliente (email, fecha_ini_ses) VALUES ( ?, ?);";
        $stmntLoggin = $this->conn->prepare($logginQuery);
        
        $emailSession = $cliente->getEmail();
        $fecha_ini_sess = $cliente->getFechaInit();
        $stmntLoggin->bind_param('ss', $emailSession, $fecha_ini_sess);
        if ($stmntLoggin->execute()) {
            return true;
        }
        else {
        return false;
        }

    }
    public function createSesionVend($email) {
        $sessionCliente = new Session();

        $sessionCliente->setEmail($email);
        $sessionCliente->setFechaInit(date('Y-m-j H:i:s'));
        try {
            return $this->createVendedorSession($sessionCliente);
        } catch (Exception $e) {
            throw new Exception ("Error ".$e->getMessage());
        }
    }

    public function createVendedorSession($cliente) {
        $logginQuery = "INSERT INTO vendedorSesion (email, fecha_ini_ses) VALUES ( ?, ?);";
        $stmntLoggin = $this->conn->prepare($logginQuery);
        
        $emailSession = $cliente->getEmail();
        $fecha_ini_sess = $cliente->getFechaInit();
        $stmntLoggin->bind_param('ss', $emailSession, $fecha_ini_sess);
        if ($stmntLoggin->execute()) {
            return true;
        }
        else {
        return false;
        }

    }


}