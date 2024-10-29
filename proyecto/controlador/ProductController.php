<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Producto.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class ProductController extends Database
{
    public function create($data)
    {
        $producto = new Producto();
        $producto->setIdUsuVen($data['id_usu_ven']);
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setOrigen($data['origen']);
        $producto->setStock($data['stock']);
        $producto->setPrecio($data['precio']);

        $images = $data['images'] ?? [];

        try {
            return $this->createProduct($producto, $images);
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function createProduct($producto, $images)
    {
        $query = 'INSERT INTO productos (id_usu_ven, nombre, precio, origen, stock, descripcion, estado) 
              VALUES (?, ?, ?, ?, ?, ?, ?);';
        $stmt = $this->conn->prepare($query);

        $idUsuVen = $producto->getIdUsuVen();
        $titulo = $producto->getTitulo();
        $precio = $producto->getPrecio();
        $origen = $producto->getOrigen();
        $stock = $producto->getStock();
        $descripcion = $producto->getDescripcion();
        $estado = $producto->getEstado();

        $stmt->bind_param(
            'ssdssss',
            $idUsuVen,
            $titulo,
            $precio,
            $origen,
            $stock,
            $descripcion,
            $estado
        );

        if ($stmt->execute()) {
            $productId = $this->conn->insert_id;

            foreach ($images as $image) {
                $this->insertProductImage($productId, $image);
            }

            return true;
        } else {
            throw new Exception("Error al crear producto: " . $stmt->error);
        }
    }
    private function insertProductImage($productId, $image)
    {
        $query = 'INSERT INTO producto_imagenes (producto_sku, imagen_url) VALUES (?, ?);';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $productId, $image);

        if (!$stmt->execute()) {
            throw new Exception("Error al insertar imagen: " . $stmt->error);
        }
    }

    public function getCategories()
    {
        $query = 'SELECT id_categoria, nombre FROM categorias';
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            $categories = [];
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
            return $categories ?? [];
        } else {
            throw new Exception("Error al cargar categorias");
        }
    }

    public function getProductsByLimit($offset = 0, $limit = 15)
    {
        $query = 'SELECT * FROM productos WHERE activo=1 LIMIT ?, ?;';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $offset, $limit);
        try {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        } catch (Exception $err) {
            echo "Error en la base de datos" . $err->getMessage();
        }
    }

    public function searchProductsByTitleOrDescripcion($searchTerm)
    {
        $query = 'SELECT * FROM productos WHERE activo=1 AND (titulo LIKE ? OR descripcion LIKE ?);';
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
        $query = "SELECT * FROM productos WHERE activo=1 AND sku= ?;";
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
        $query = "SELECT * FROM productos WHERE activo=0;";
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
        $query = "UPDATE productos SET nombre=?, precio=?, origen=?, stock=?, descripcion=? WHERE sku=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            'sssssi',
            $data['nombre'],
            $data['precio'],
            $data['origen'],
            $data['stock'],
            $data['descripcion'],
            $data['product_sku']
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

            $queryProductos = "DELETE FROM productos WHERE sku = ?";
            $stmtProductos = $this->conn->prepare($queryProductos);
            $stmtProductos->bind_param('i', $productId);

            if (!$stmtProductos->execute()) {
                throw new Exception("Error en productos: " . $stmtProductos->error);
            }
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Error: " . $e->getMessage());
            return false;
        } finally {
            $stmtCarrito->close();
            $stmtProductos->close();
        }
    }
    public function activateProduct($productId)
    {
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
            throw new Exception("Error" . $err->getMessage());
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
