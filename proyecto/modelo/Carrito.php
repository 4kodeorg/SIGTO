<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/modelo/Item.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/Database.php';

class Carrito extends Item {

    private array $items = [];
    private int $total;

    public function addItem($item){
        $this->items[] = $item;
    }
    public function getItems() {
        return $this->items;
    }

    public function getTotal(){
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getPriceProduct() * $item->getQuantity();
        }
        return $total;
    }
    public function setTotal() {
        return $this->getTotal();
    }

    
}