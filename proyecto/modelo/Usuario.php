<?php

require_once './config/db.php';

class Usuario extends Database{
    private $conn;
    private $table_name = "usuarios";

    private int $id;
    private string $nombre;
    private string $correo;
    private int $celular;
    private string $direccion;
    private string $seg_direccion;

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getCorreo() {
        return $this->correo;
    }
    public function setCorreo($correo) {
        $this->correo = $correo;
    }
    public function getCelular() {
        return $this->celular;
    }
    public function setCelular($celular) {
        $this->celular = $celular;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function getSegDireccion() {
        return $this->seg_direccion;
    }
    public function setSegDireccion($seg_direccion) {
        $this->seg_direccion = $seg_direccion;
    }

    public function createNew() {
        $query = "INSERT INTO ". $this->table_name . "SET nombre=?, correo=?, celular=?, direccion=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssis", $this->nombre, $this->correo, $this->celular, $this->direccion);

        try {
            $stmt->execute();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUserById() {
        $query = "SELECT * FROM " .$this->table_name ." WHERE ID=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    public function updateUserData() {
        $query = "UPDATE ". $this->table_name .
        " SET nombre=?, correo=?, celular=?, direccion=?, seg_direccion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiss", $this->id);

        return $stmt->execute();
    }
    public function updateAdress() {
        $query = "UPDATE ". $this->table_name .
        "SET direccion=?, seg_direccion=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $this->id);

        return $stmt->execute();
    }
}


?>