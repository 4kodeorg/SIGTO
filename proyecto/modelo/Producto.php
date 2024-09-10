<?php 

class Producto{

    private int $id;
    private string $titulo;
    private string $descripcion;
    private string $precio;
    private string $origen;
    private string $cantidad;

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
    public function getOrigen() {
        return $this->origen;
    }
    public function setOrigen($origen) {
        $this->precio = $origen;
    }
    public function getCantidad() {
        return $this->cantidad;
    }
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
}






