<?php

class Database {
    
    private $host = "127.0.0.1:3306";
    private $db_name = "dbtest";
    private $user = "superman";
    private $password = "test";
    private $conn;


    public function getConnection()
    {
        $this->conn = null;
            try { 
                $this->conn = new mysqli(
                    $this->host,$this->user, $this->password, $this->db_name); }
            catch (Exception $e) {
                echo "Error al conectar con la base de datos". $e->getMessage();
            }
            return $this->conn;
    }
}