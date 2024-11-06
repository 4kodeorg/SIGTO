<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Vendedor.php';

class VendController extends Database
{
    public function create($data)
    {
        $vendedor = new Vendedor();

        $vendedor->setEmail($data['email']);
        $vendedor->setRazonSocial($data['razon_social']);
        $vendedor->setPassword($data['confirm_pwd']);
        $vendedor->setFechaNac($data['fecha_nac']);
        $vendedor->setFechaRegistro(date('Y-m-j H:i:s'));
        $vendedor->setNombre($data['nombre']);
        $vendedor->setApellido($data['apellido']);

        try {
            return $this->createUserVendedor($vendedor);
        } catch (Exception $e) {
            throw new Exception("Error " . $e->getMessage());
        }
    }

    public function createUserVendedor($vendedor)
    {
        try {
            $query = "INSERT INTO vendedor (email, razon_social, password, fecha_registro, nombre, apellido, fecha_nac) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = $this->conn->prepare($query);

            $email = $vendedor->getEmail();
            $razon_social = $vendedor->getRazonSocial();
            $password = $vendedor->getPassword();
            $fecha_reg = $vendedor->getFechaRegistro();
            $nombre = $vendedor->getNombre();
            $apellido = $vendedor->getApellido();
            $fecha_nac = $vendedor->getFechaNac();

            $stmt->bind_param('sssssss', $email, $razon_social, $password, $fecha_reg, $nombre, $apellido, $fecha_nac);

            if ($stmt->execute()) {
                $stmt->close();
                $vendedorEmail = $vendedor->getEmail();
                return $this->getUserById($vendedorEmail);
            }
             else {
                throw new Error("Error al buscar usuario vendedor");
            }
        } catch (Exception $err) {
            error_log("Error: " . $err->getMessage());
            return false;
        } 
    }
    public function insertUserVendId ($email) {
        $query = "INSERT INTO usuario_ven (email) values (?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserVendId ($email) {
        $query = "SELECT * FROM usuario_ven WHERE email=?;";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s',$email);

        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows == 1) {
                return $res->fetch_assoc();
            }
        } else {
            return false;
        }
    }
    public function getUserById($vendedorId) {
        $query = "SELECT * FROM vendedor WHERE email = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $vendedorId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $vendedor = $result->fetch_assoc();
            $stmt->close();
            return $vendedor;
        } else {
            throw new Exception("Error en la base datos");
        }
    }
    public function validateUser($username, $password)
    {

        $query = 'SELECT * FROM vendedor WHERE email=?';
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la base de datos");
        }
        $paramUsername = $username;
        $stmt->bind_param('s', $paramUsername);

        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows == 1) {
                $usuario = $res->fetch_assoc();
                if (!$usuario) {
                    return false;
                }
                $passwd = $usuario['password'];
                if (password_verify($password, $passwd)) {
                    return $usuario;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            throw new Exception("Error en el servidor");
        }
    }
    public function getUserProducts($idVendedor) {
        $query = "SELECT * FROM productos WHERE id_usu_ven =? AND activo=1;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $idVendedor);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $productos = [];
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
            return $productos ?? [];
        } else {
            throw new Exception("Error al cargar productos");
        }
    }
}
