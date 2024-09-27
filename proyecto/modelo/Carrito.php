<?php

class Carrito {
    protected $items_carrito = array();

    private int $id_producto;
    private int $id_usuario;
    private int $cantidad;
    private int $total;

    public function setIdProducto($id_producto) {
        $this->id_producto = $id_producto;
    }
    public function setIdUsuario($id_usuario) {
        $this->id_producto = $id_usuario;
    }
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    public function setTotal($total) {
        $this->total = $total;
    }

    public function getIdProducto() {
        return $this->id_producto;
    }
    public function getIdUsuario() {
        return $this->id_usuario;
    }
    public function getCantidad() {
        return $this->cantidad;
    }
    public function getTotal() {
        return $this->total;
    }

    
}