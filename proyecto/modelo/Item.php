<?php
class Item {
    private string $titulo;
    private int $id_product;
    private int $id_user;
    private int $id_user_ven;
    private int $quantity;
    private float $price_product;
    private string $fecha_gen;


   

    public function setIdProduct($id_product){
        $this->id_product = $id_product;
    }
    public function setIdUserVen($id_user_ven) {
        $this->id_user_ven = $id_user_ven;
    }
    public function setFechaGen($fecha_gen) {
        $this->fecha_gen = $fecha_gen;
    }
    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }
    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setPriceProduct($price_product) {
        $this->price_product = $price_product;
    }
   
    public function getTitulo() {
        return $this->titulo;
    }

    public function getIdProduct() {
        return $this->id_product;
    }
    public function getIdUserVen() {
        return $this->id_user_ven;
    }
    public function getIdUser() {
        return $this->id_user;
    }
    public function getFechaGen() {
        return $this->fecha_gen;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPriceProduct() {
        return $this->price_product;
    }
}

