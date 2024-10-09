<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Carrito.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class CartController extends Database
{
    public function create ($data) {
        $carrito = new Carrito();
        $carrito->setIdProducto($data['id_product']);
        $carrito->setIdUsuario($data['id_user']);
        $carrito->setCantidad($data['quantity']);
        $carrito->setTotal($data['total']);
        
        try {
            return $this->createCart($carrito);  
        }
        catch (Exception $e) {
            echo 'Error: ' .$e->getMessage();
        }
    }
    public function createCart ($carrito) {
        $query = "INSERT INTO carrito (id_prod, id_usuario, cantidad, total) VALUES ( ?, ?, ?, ?);";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            echo "Error: (" . $this->conn->errno . ") " . $this->conn->error;
            return false;
        }
        $idProducto = $carrito->getIdProducto();
        $idUsuario = $carrito->getIdUsuario();
        $quantity = $carrito->getCantidad();
        $total = $carrito->getTotal();
        
        $stmt->bind_param('iiii', 
                $idProducto, 
                $idUsuario, 
                $quantity, 
                $total);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }


    public function removeProductFromCart($productId, $idUsuario) {
        $query = "DELETE FROM carrito WHERE id_prod= ? AND id_usuario=? ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii'
                ,$productId, $idUsuario);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getUserCarrito ($userId) {
        $query = "SELECT * FROM carrito WHERE id_usuario = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $userCart = $result->fetch_all(MYSQLI_ASSOC); 
            }
            else {
                $userCart = [];
            }
            $stmt->close();
            return $userCart;
        }

    }
}
