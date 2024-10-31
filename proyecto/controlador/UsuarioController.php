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
        $cliente->setPassword($data['confirm_pwd']);
        try {
            return $this->createUserComprador($cliente);
        } catch (Exception $e) {
            throw new Exception("Error " . $e->getMessage());
        }
    }
    public function createUserComprador($cliente)
    {
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

            if ($stmtCliente->execute()) {
                $stmtCliente->close();
                $compradorQuery = "INSERT INTO comprador (email) VALUES (?);";
                $stmtComprador = $this->conn->prepare($compradorQuery);
                $userEmail = $cliente->getEmail();
                $stmtComprador->bind_param("s", $userEmail);
                if ($stmtComprador->execute()) {
                    $stmtComprador->close();
                    return $this->getUserbyId($cliente->getEmail());
                }
            }
        } catch (Exception $err) {
            error_log("Error: " . $err->getMessage());
            return false;
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
    public function addUserDirecciones($data)
    {
        $query = "INSERT INTO comprador_direccion (email, calle_pri, calle_sec, num_puerta, num_apartamento, ciudad, tipo_direccion) VALUES (?, ?, ?, ?, ?, ?) ;";
        $stmt = $this->conn->prepare($query);
        $email = $data['email'];
        $callePrimaria = $data['calle_pri'];
        $calleSecundaria = $data['calle_seg'];
        $numPuerta = $data['num_puerta'];
        $numApartamento = $data['num_apartamento'];
        $ciudad = $data['ciudad'];
        $tipoDireccion = $data['tipo_dir'];

        $stmt->bind_param(
            'sssiisss',
            pack("H*", $email),
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
    public function getUserCards($email) {
        $query = "SELECT * FROM comprador_metodos_pago where email=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s',$email);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $stmt->close();
                return $res->fetch_assoc();
            } else {
                return [];
            }
        } else {
            $stmt->close();
            return false;
        }

    }
    public function getCompradorDirecciones($email)
    {
        $query = "SELECT * FROM comprador_direccion where email=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $stmt->close();
                return $res->fetch_assoc();
            } else {
                return [];
            }
        } else {
            $stmt->close();
            return false;
        }
    }
    public function updateUserDirecciones($userData)
    {
        $query = "UPDATE comprador_direccion SET calle_pri= ?, calle_sec= ?, num_puerta= ?, num_apartamento= ?, ciudad= ?, tipo_dir=? WHERE id_direccion= ?;";
        $stmt = $this->conn->prepare($query);

        $callePrimaria = $userData['calle_prim'];
        $calleSecundaria = $userData['calle_seg'];
        $numPuerta = $userData['num_puerta'];
        $numApartamento = $userData['num_apartamento'];
        $ciudad = $userData['ciudad'];
        $tipoDireccion = $userData['tipo_dir'];
        $idDireccion = $userData['id_direccion'];
        $stmt->bind_param('ssiisssi', $callePrimaria, $calleSecundaria, $numPuerta, $numApartamento, $ciudad, $tipoDireccion, $idDireccion);

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
            INNER JOIN favoritos ON productos.sku = favoritos.sku
            WHERE favoritos.id_usuario = ?;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);


        if ($stmt->execute()) {
            $result = $stmt->get_result();

            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    public function createUserPhones($email, $phone)
    {
        $query = "INSERT INTO comprador_telefono (email, telefono) VALUES ( ?, ? );";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('si', $email, $phone);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserComprador($email)
    {
        $query = "SELECT * FROM comprador where email=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $comprador = [];
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows == 1) {
                $comprador = $res->fetch_assoc();
                $stmt->close();
                return $comprador;
            } else {
                $stmt->close();
                return $comprador;
            }
        }
    }
    public function getUserPhones($email)
    {
        $query = "SELECT * FROM comprador_telefono where email=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $email);
        $userPhones = [];
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows == 1) {
                $userPhones = $res->fetch_assoc();
                $stmt->close();
                return $userPhones;
            } else {
                $stmt->close();
                return $userPhones;
            }
        }
    }
    public function updateUserPhone($email, $phone)
    {
        $query = "UPDATE comprador_telefono SET telefono =? WHERE email =?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('is', $phone, $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserData($nombre1, $nombre2, $apellido1, $apellido2, $email)
    {
        $query = "UPDATE comprador SET nombre1=?, nombre2=?, apellido1=?, apellido2=? WHERE email=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssss', $nombre1, $nombre2, $apellido1, $apellido2, $email);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserbyId($idUser)
    {
        $query = "SELECT * FROM cliente WHERE email = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $idUser);
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
        $query = "INSERT into favoritos (sku, id_usuario) VALUES (?, ?);";
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
        $query = "SELECT * FROM favoritos WHERE id_usuario=?;";
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
        $query = "DELETE FROM favoritos WHERE id_usuario=? AND id_sku=?;";
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
