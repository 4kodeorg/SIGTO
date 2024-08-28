<?php 

require_once './config/db.php';

class Producto {
    private $conn;
    private $table_name = "productos";

    private int $id;
    private string $titulo;
    private string $descripcion;
    private string $precio;
    private string $cantidad;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
        
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    public function getCantidad() {
        return $this->cantidad;
    }
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function create() {
        $query = "INSERT INTO ". $this->table_name . "SET titulo=?, descripcion=?, precio=?, cantidad=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssss", $this->titulo, $this->descripcion, $this->precio, $this->cantidad);

        try {
            $stmt->execute();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function readAll() {
        $query = "SELECT * FROM ". $this->table_name;
        return $this->conn->query($query);
    }

    public function update() {
        $query = "UPDATE ". $this->table_name ."SET titulo=?, descripcion=?, precio=?, cantidad=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ssss",$this->titulo, $this->descripcion, $this->precio, $this->cantidad);

        return $stmt->execute();
    }
    public function delete() {
        $query = "DELETE FROM ". $this->table_name ." WHERE id=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);

        return $stmt->execute();
    }

}



?>


