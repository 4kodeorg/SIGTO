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
    public function getPrecio(): float
    {
        return $this->precio;
    }
    public function getOrigen(): string
    {
        return $this->origen;
    }
    public function getStock(): int
    {
        return $this->stock;
    }
    public function getEstado(): string
    {
        return $this->estado;
    }
}
