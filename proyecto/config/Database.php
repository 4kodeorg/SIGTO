<?php

class Database {
    
    private $host = "db";
    private $port = 3306;
    private $db_name = "sigto";
    private $user = "root";
    private $password = "passwd123";
    protected $conn;


    public function __construct() {
        $this->conn = null;
        try {
            $this->conn = new mysqli(
                $this->host, $this->user, $this->password, $this->db_name, $this->port
            );
    
            if ($this->conn->connect_error) {
                throw new Exception("Error al conectar: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo "Error al conectar con la base de datos: " . $e->getMessage();
        }
    }
}