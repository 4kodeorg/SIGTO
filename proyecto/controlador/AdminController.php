<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class AdminController extends Database {

    public function validateLogin($email, $password) {
        $query = "SELECT * FROM administrador WHERE email=?;";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows == 1) {
                $admin = $res->fetch_assoc();

                if ($admin['password'] === $password) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public function suspendClienteAcc($email) {
        $query = "UPDATE cliente SET suspended=1 WHERE email=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function unsuspendCliente($email) {
        $query = "UPDATE cliente SET suspended=0 WHERE email=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function addCategory($nombre, $desc) {
        $query = "INSERT INTO categorias (nombre, descripcion) VALUES (?, ?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ss', $nombre, $desc);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function addSubCategory() {

    }
   
    public function listCuentasVendedores() {
        $query = "SELECT * FROM vendedor;";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        else {
            return false;
        }
    }
    public function listCuentasCompradores() {
        $query = "SELECT * FROM comprador;";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        else {
            return false;
        }
    }
    public function getAllClientes() {
        $query = "SELECT * FROM cliente";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()){
            $result = $stmt->get_result();
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getCompradorByEmail( $email) {
        $query = "SELECT * FROM comprador WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getCompradorDirecciones($email) {
        $query = "SELECT * FROM comprador_direccion WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getCompradorTelefono($email) {
        $query = "SELECT * FROM comprador_telefono WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    public function getCompradorMetodosPago($email) {
        $query = "SELECT * FROM comprador_metodos_pago WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllCategorias() {
        $query = "SELECT * FROM categorias";
        $result = $this->conn->prepare($query)->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllVendedorSesiones() {
        $query = "SELECT * FROM vendedorSesion";
        $result = $this->conn->prepare($query)->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllClienteSesiones() {
        $query = "SELECT * FROM sesionCliente";
        $result = $this->conn->prepare($query)->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}