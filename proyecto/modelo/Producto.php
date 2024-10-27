<?php 

class Producto{

    private string $sku;
    private string $titulo;
    private string $descripcion;
    private string $precio;
    private string $origen;
    private string $cantidad;
    private int $id_category;

    public function getSku() {
        return $this->sku;
    }
    public function setSku($sku) {
        $this->sku = $sku;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function setDescripcion($descripcion) { 
        $this->descripcion = $descripcion;
    }
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    public function setOrigen($origen) {
        $this->origen = $origen;
    } 
    public function setIdCategory($id_category) {
        $this->id_category = $id_category;
    }
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getIdCategory() {
        return $this->id_category;
    }
    public function getOrigen() {
        return $this->origen;
    }
    public function getCantidad() {
        return $this->cantidad;
    }
   
}






