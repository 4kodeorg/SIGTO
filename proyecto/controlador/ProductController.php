<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/modelo/Producto.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/Database.php';

class ProductController extends Database {
    public function create($data)
    {
        $producto = new Producto();
        $producto->setTitulo($data['titulo']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setOrigen($data['origen']);
        $producto->setCantidad($data['cantidad']);
        $producto->setPrecio($data['precio']);
        try {
            return $this->createProduct($producto);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function createProduct($producto)
    {
        $query = 'INSERT INTO productos (titulo, descripcion, origen, cantidad, precio) VALUES (?, ?, ?, ?, ?);';
        $stmt = $this->conn->prepare($query);
      
        $titulo = $producto->getTitulo();
        $descripcion = $producto->getDescripcion();
        $origen = $producto->getOrigen();
        $cantidad = $producto->getCantidad();
        $precio = $producto->getPrecio();
    
        $stmt->bind_param(
            'sssss', $titulo, $descripcion, $origen, $cantidad, $precio     
        );
        error_log("Error: " . $stmt->error);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            throw new Exception("Error al crear producto");
        }
    }

}

