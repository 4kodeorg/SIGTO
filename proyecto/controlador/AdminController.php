<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class AdminController extends Database {

    public function validateLogin($email) {
        $query = "SELECT * FROM administrador WHERE email=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $email);
    }
    public function addCategory() {

    }
    public function addSubCategory() {

    }
    public function listInfoVendedores() {

    }
    public function listInfoCompradores() {

    }
    public function listCuentasVendedores() {

    }
    public function listCuentasCompradores() {

    }
}