<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/Database.php';

class UsuarioController extends Database
{
    public function create($data)
    {
        $cliente = new Usuario();

        $cliente->setEmail($data['email']);
        $cliente->setUsername($data['username']);
        $cliente->setFechaNac($data['fecha_nac']);
        $cliente->setFechaRegistro(date('Y-m-j H:i:s'));
        $cliente->setPais($data['pais']);
        $cliente->setPassword($data['confirm_passwd']);
        try {
            return $this->createUserComprador($cliente);
        } catch (Exception $e) {
            throw new Exception("Error " . $e->getMessage());
        }
    }
    public function createUserComprador($cliente)
    {
        $this->conn->begin_transaction();
        try {
            $queryCliente = "INSERT INTO cliente (email, username, password, fecha_registro, fecha_nac, pais) VALUES (?, ?, ?, ?, ?, ?);";
            $stmtCliente = $this->conn->prepare($queryCliente);

            $email = $cliente->getEmail();
            $username = $cliente->getUsername();
            $passw = $cliente->getPassword();
            $fecha_registro = $cliente->getFechaRegistro();
            $pais = $cliente->getPais();
            $fecha_nac = $cliente->getFechaNac();

            $stmtCliente->bind_param(
                'ssssss',
                $email,
                $username,
                $passw,
                $fecha_registro,
                $fecha_nac,
                $pais
            );

            if (!$stmtCliente->execute()) {
                throw new Exception("Error en la consulta" . $stmtCliente->error);
            }

            $compradorQuery = "INSERT INTO comprador (email) VALUES (?);";
            $stmtComprador = $this->conn->prepare($compradorQuery);

            $stmtComprador->bind_param("s", $cliente->getEmail());

            if (!$stmtComprador->execute()) {
                throw new Exception("Error en cliente comprador" . $stmtComprador->error);
            }

            $dataQuery = "SELECT * FROM cliente WHERE email=?;";
            $stmtnData = $this->conn->prepare($dataQuery);
            $stmtnData->bind_param('s', $cliente->getEmail());
            if ($stmtnData->execute()) {
                $res = $stmtnData->get_result();
                if ($res->num_rows == 1) {
                    $this->conn->commit();
                    return $res->fetch_assoc();
                }
            } else {
                throw new Exception("Error al buscar cliente");
            }
        } catch (Exception $err) {
            $this->conn->rollback();
            error_log("Error: " . $err->getMessage());
            return false;
        } finally {
            $stmtCliente->close();
            $stmtComprador->close();
            $stmtnData->close();
        }
    }
    public function updateUserPersonalData($emailUser, $name1, $name2, $lastname1, $lastname2)
    {
        $query = "UPDATE comprador SET nombre1=?, nombre2=? ,apellido1=?, apellido2=? WHERE email=?;";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error: " . $this->conn->error);
        }
        $stmt->bind_param('sssss', $name1, $name2, $lastname1, $lastname2, $emailUser);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function validateUser($username, $password)
    {

        $query = 'SELECT * FROM cliente WHERE email=?';
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
    public function addUserDirecciones($email, $callePrimaria, $calleSecundaria, $numPuerta, $numApartamento, $ciudad, $pais, $tipoDireccion)
    {
        $query = "INSERT INTO comprador_direccion (email, calle_primaria, calle_secundaria, num_puerta, num_apartamento, ciudad, pais, tipo_direccion) VALUES (?, ?, ?, ?, ?, ?, ?) ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            'sssiisss',
            $email,
            $callePrimaria,
            $calleSecundaria,
            $numPuerta,
            $numApartamento,
            $ciudad,
            $pais,
            $tipoDireccion
        );

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function addUserPhone($email, $telefono) {
        $query = "INSERT INTO comprador_telefono (email, telefono) VALUES ( ? , ?);";
        $stmt = $this->conn->prepare($query);


        $stmt->bind_param('si', $email, $telefono);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserProductFavs($userId)
    {
        $query = "
            SELECT productos.* 
            FROM productos
            INNER JOIN favoritos ON productos.id = favoritos.id_prod
            WHERE favoritos.id_user = ?;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateUserData($idUser, $newEmail, $newPhone, $newUser)
    {
        $query = "UPDATE usuarios SET email=?, username=?, telefono=? WHERE id=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssii', $newEmail, $newUser, $newPhone, $idUser);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserbyId($idUser)
    {
        $query = "SELECT * FROM usuarios WHERE id = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idUser);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();
            $stmt->close();
            return $usuario;
        } else {
            throw new Exception("Error en la base datos");
        }
    }

    public function addToFav($idUser, $idProd)
    {
        $query = "INSERT into favoritos (id_user, id_prod) VALUES (?, ?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $idUser, $idProd);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserFavorites($idUser)
    {
        $query = "SELECT * FROM favoritos WHERE id_user=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idUser);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $favoritos = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $favoritos = [];
            }
            $stmt->close();
            return $favoritos;
        } else {
            throw new Exception("Error en la base de datos");
        }
    }
    public function deleteFromFavorites($idUser, $idProd)
    {
        $query = "DELETE FROM favoritos WHERE id_user=? AND id_prod=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $idUser, $idProd);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}
