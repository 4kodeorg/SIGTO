<?php 

class SesionDeCompra {
    private int $id;
    private string $sess_id;
    private array $articulos;
    private int $precioArticulo;


    public function setSessionId($sess_id) {
        $this->sess_id = $sess_id;
    }
    public function setArticulos ($articulos) {
        $this->articulos = $articulos;
    }
    public function setPriceArticle($articulos) {
        foreach ($articulos as $art) {
            $this->precioArticulo = $art['precio'];
        }
    }
    public function getSessionId() {
        return $this->sess_id;
    }
    public function getArticulos() {
        return $this->articulos;
    }
    public function getPrecioArticulo() {
        return $this->precioArticulo;
    }
}