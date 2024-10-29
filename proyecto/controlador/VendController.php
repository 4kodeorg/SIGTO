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

        $this->conn->begin_transaction();

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

            $stmt->bind_param('sisssss', $email, $razon_social, $password, $fecha_reg, $nombre, $apellido, $fecha_nac);

            if (!$stmt->execute()) {
                throw new Exception("Error en el servidor" . $stmt->error);
            }

            $clienteQuery = "SELECT * FROM vendedor WHERE email=?;";
            $stmtCliente = $this->conn->prepare($clienteQuery);

            $stmtCliente->bind_param('s', $vendedor->getEmail());

            if ($stmtCliente->execute()) {
                $res = $stmtCliente->get_result();
                if ($res->num_rows == 1) {
                    $this->conn->commit();
                    return $res->fetch_assoc();
                }
            } else {
                throw new Error("Error al buscar usuario vendedor");
            }
        } catch (Exception $err) {
            $this->conn->rollback();
            error_log("Error: " . $err->getMessage());
            return false;
        } finally {
            $stmt->close();
            $stmtCliente->close();
        }
    }
    public function getUserById($vendedorId) {
        $query = "SELECT * FROM vendedor WHERE email = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $vendedorId);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $vendedor = $result->fetch_assoc();
            $stmt->close();
            return $vendedor;
        } else {
            throw new Exception("Error en la base datos");
        }
    }
}
