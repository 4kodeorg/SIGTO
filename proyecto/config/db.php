<?php

class Database {
    
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "dbtest";
    private $user = "superman";
    private $password = "test";
    private $conn;


    public function __construct()
    {
    $this->conn = null;
        try { 
            $this->conn = new mysqli(
                $this->host,$this->user, $this->password, $this->db_name, $this->port);
                if (mysqli_connect_errno()) {
                    throw new Exception("No se pudo establecer la conexión");
                } 
            }
            catch (Exception $e) {
                echo "Error al conectar con la base de datos". $e->getMessage();
            }
            return $this->conn;
    }
}