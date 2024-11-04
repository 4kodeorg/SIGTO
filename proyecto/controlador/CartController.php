<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Item.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Carrito.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class CartController extends Database
{
    public function updateCart($data) {
        $idUser = $data['id_comprador'];
        $idProducto = $data['sku'];
        $existingCart = $this->getUserCarrito($idUser);
        
        $productIdUpdate = 0;
        $currentQuant = 0;
        foreach ($existingCart as $itemCart) {
            if ($itemCart['sku_prod'] == $idProducto) {
                $productIdUpdate = $itemCart['sku_prod'];
                $currentQuant = $itemCart['cantidad'];
            }
        }
        if ($productIdUpdate != 0) {
            $query = "UPDATE carrito SET cantidad = ? WHERE sku_prod =? AND id_usu_com=?;";
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
            $item->setIdProduct($data['sku']);
            $item->setIdUser($data['id_comprador']);
            $item->setIdUserVen($data['id_vendedor']);
            $item->setQuantity($data['cantidad']);
            $item->setFechaGen(date('Y-m-d H:i:s'));
            $item->setPriceProduct($data['price_product']);
           
            
            $idProducto = $item->getIdProduct();
            $idUsuario = $item->getIdUser();
            $titulo = $item->getTitulo();
            $idUsuarioVend = $item->getIdUserVen();
            $fechaGen = $item->getFechaGen();
            $quantity = $item->getQuantity();
            $priceProduct = $item->getPriceProduct();

            $query = "INSERT INTO carrito (fecha_gen, sku_prod, id_usu_com, id_usu_ven ,cantidad ,titulo, precio_prod) 
                                VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Error :". $this->conn->error);
            }
            $stmt->bind_param('siiiisd', $fechaGen, $idProducto, $idUsuario, $idUsuarioVend, $quantity, $titulo, $priceProduct);
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
        $query = "DELETE FROM carrito WHERE sku_prod= ? AND id_usu_com=? ;";
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
        $query = "SELECT * FROM carrito where id_usu_com= ?;";
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
        $query = "SELECT * FROM carrito WHERE id_usu_com = ?;";
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
