<?php
require_once 'modelo/Producto.php';

class ProductController {
    public function create($data) {
        $producto = new Producto();
        $producto->setTitulo($data['titulo']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setCantidad($data['cantidad']);
        $producto->setPrecio($data['precio']);
    
    try {
        $producto->createNew();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    }


}

?>