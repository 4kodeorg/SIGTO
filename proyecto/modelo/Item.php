<?php
class Item {
    private string $titulo;
    private int $id_product;
    private int $id_user;
    private int $quantity;
    private float $price_product;


   

    public function setIdProduct($id_product){
        $this->id_product = $id_product;
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

    public function getIdUser() {
        return $this->id_user;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPriceProduct() {
        return $this->price_product;
    }
}

