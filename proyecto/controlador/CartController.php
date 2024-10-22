<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Item.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Carrito.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class CartController extends Database
{
    public function updateCart($data) {
        $idUser = $data['id_usuario'];
        $idProducto = $data['id_prod'];
        $existingCart = $this->getUserCarrito($idUser);
        
        $productIdUpdate = 0;
        $currentQuant = 0;
        foreach ($existingCart as $itemCart) {
            if ($itemCart['id_prod'] == $idProducto) {
                $productIdUpdate = $itemCart['id_prod'];
                $currentQuant = $itemCart['cantidad'];
            }
        }
        if ($productIdUpdate != 0) {
            $query = "UPDATE carrito SET cantidad = ? WHERE id_prod =? AND id_usuario=?;";
            $stmt = $this->conn->prepare($query);
            $newQuantity = $currentQuant + $data['cantidad'];
            $stmt->bind_param('iii', $newQuantity, $productIdUpdate, $idUser);
            
            if ($stmt->execute()) {
                return true;
            }
            else { return false; }
            
            $stmt->close();
            
        } else {
            $item = new Item();
            $item->setTitulo($data['titulo']);
            $item->setIdProduct($data['id_prod']);
            $item->setIdUser($data['id_usuario']);
            $item->setQuantity($data['cantidad']);
            $item->setPriceProduct($data['price_product']);
           
            
            $idProducto = $item->getIdProduct();
            $idUsuario = $item->getIdUser();
            $titulo = $item->getTitulo();
            $quantity = $item->getQuantity();
            $priceProduct = $item->getPriceProduct();

            $query = "INSERT INTO carrito (id_prod, id_usuario, titulo, cantidad, price_product) 
                                VALUES (?, ?, ?, ?, ?);";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Error :". $this->conn->error);
            }
            $stmt->bind_param('iisid', $idProducto, $idUsuario, $titulo, $quantity, $priceProduct);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
            $stmt->close();
    }
        
    }
    
    public function removeProductFromCart($productId, $idUsuario)
    {
        $query = "DELETE FROM carrito WHERE id_prod= ? AND id_usuario=? ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'ii',
            $productId,
            $idUsuario
        );
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
    public function getUserCartById($cartId) {
        $query = "SELECT * FROM carrito where id= ?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i',$cartId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $carrito = [];
            while ($row = $result->fetch_assoc()) {
                $carrito[] = $row;
            }
            $stmt->close();
            return $carrito;
        } else {
            $stmt->close();
            return [];
        }

    }
    public function getUserCarrito($userId)
    {
        $query = "SELECT * FROM carrito WHERE id_usuario = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $userCart = [];

            while ($row = $result->fetch_assoc()) {
                $userCart[] = $row;
            }

            $carrito = $userCart;
            $stmt->close();
            return $carrito;
        } else {
            $stmt->close();
            return [];
        }
    }
}
