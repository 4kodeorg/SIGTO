<?php

class Carrito {
    private int $id;
    private int $total;
    private int $priceArticle;
    private int $quantityArticles;


    public function setTotal($total) {
        $this->total = $total;
    }
    public function getTotal() {
        return $this->total;
    }
    
}