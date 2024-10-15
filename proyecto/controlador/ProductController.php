<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/modelo/Producto.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/Database.php';

class ProductController extends Database {
    public function create($data)
    {
        $producto = new Producto();
        $producto->setTitulo($data['titulo']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setOrigen($data['origen']);
        $producto->setCantidad($data['cantidad']);
        $producto->setPrecio($data['precio']);
        try {
            return $this->createProduct($producto);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function createProduct($producto)
    {
        $query = 'INSERT INTO productos (titulo, descripcion, origen, cantidad, precio) VALUES (?, ?, ?, ?, ?);';
        $stmt = $this->conn->prepare($query);
      
        $titulo = $producto->getTitulo();
        $descripcion = $producto->getDescripcion();
        $origen = $producto->getOrigen();
        $cantidad = $producto->getCantidad();
        $precio = $producto->getPrecio();
    
        $stmt->bind_param(
            'sssss', $titulo, $descripcion, $origen, $cantidad, $precio     
        );
        error_log("Error: " . $stmt->error);
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            throw new Exception("Error al crear producto");
        }
    }

    public function getFirstTenProducts() {
        $query = 'SELECT * FROM productos LIMIT 10;';
    }

    public function searchProductsByTitleOrDescripcion($searchTerm)
    {
        $query = 'SELECT * FROM productos WHERE estado=1 AND (titulo LIKE ? OR descripcion LIKE ?);';
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al buscar");
        }
        $searchParamComodines = '%' . $searchTerm . '%';
        $stmt->bind_param('ss', $searchParamComodines, $searchParamComodines);
        $stmt->execute();

        $result = $stmt->get_result();
        $productos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $productos ?: [];
    }
    public function getProductById($productId)
    {
        $query = "SELECT * FROM productos WHERE estado=1 AND id= ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();
        return $producto;
    }
    public function getDisabledProducts()
    {
        $query = "SELECT * FROM productos WHERE estado=0;";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al traer los productos desactivados");
        }
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $productos = $result->fetch_all(MYSQLI_ASSOC);
        } 
        $stmt->close();
        return $productos ?? [];

    }

    public function updateProductData($data)
    {
        $query = "UPDATE productos SET titulo=?, descripcion=?, origen=?, cantidad=?, precio=? WHERE id=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            'sssssi',
            $data['new_titulo'],
            $data['new_descripcion'],
            $data['new_origen'],
            $data['new_cantidad'],
            $data['new_precio'],
            $data['product_id']
        );
        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error al actualizar");
            }
        } catch (Exception $err) {
            throw new Exception('Error en la base de datos: ' . $err->getMessage());
        }
        $stmt->close();
    }
    public function deleteProductById($productId)
    {
        $this->conn->begin_transaction();

        try {
            $queryCarrito = "DELETE FROM carrito WHERE id_prod = ?";
            $stmtCarrito = $this->conn->prepare($queryCarrito);
            $stmtCarrito->bind_param('i', $productId);

            if (!$stmtCarrito->execute()) {
                throw new Exception("Error en carrito: " . $stmtCarrito->error);
            }

            $queryProductos = "DELETE FROM productos WHERE id = ?";
            $stmtProductos = $this->conn->prepare($queryProductos);
            $stmtProductos->bind_param('i', $productId);

            if (!$stmtProductos->execute()) {
                throw new Exception("Error en productos: " . $stmtProductos->error);
            }
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Error: " . $e->getMessage());
            return false;
        } finally {
            $stmtCarrito->close();
            $stmtProductos->close();
        }
    }
    public function activateProduct($productId) {
        $query = "UPDATE productos set estado=1 where id=?;";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al intentar activar el producto");
        }
        $stmt->bind_param('i', $productId);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $err) {
            throw new Exception("Error" .$err->getMessage());
        }
    }

    public function disableProductById($productId)
    {
        $query = "UPDATE productos set estado=0 where id=?;";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Error al intentar desactivar el producto");
        }
        $stmt->bind_param('i', $productId);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}

