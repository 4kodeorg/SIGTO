<?php

class Producto
{

    private int $idUsuVen;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private string $origen;
    private int $stock;
    private string $estado;
    private string $oferta;
    private int $idCategory;
    private int $idSubCategory;


    public function setIdUsuVen($idUsuVen)
    {
        $this->idUsuVen = $idUsuVen;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setOferta($oferta) {
        $this->oferta = $oferta;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }
    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function setIdCategory($idCategory) {
        $this->idCategory = $idCategory;
    }
    public function setIdSubCategory($idSubCategory) {
        $this->idSubCategory = $idSubCategory;
    }

    public function getIdUsuVen()
    {
        return $this->idUsuVen;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getOferta() {
        return $this->oferta;
    }
    public function getPrecio()
    {
        return $this->precio;
    }
    public function getOrigen()
    {
        return $this->origen;
    }
    public function getIdCategory() {
        return $this->idCategory;
    }
    public function getIdSubCategory() {
        return $this->idSubCategory;
    }
    public function getStock()
    {
        return $this->stock;
    }
    public function getEstado()
    {
        return $this->estado;
    }
}
