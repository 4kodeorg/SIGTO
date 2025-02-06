<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/modelo/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/controlador/BaseController.php';

class UsuarioController extends BaseController
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
    public function validateUser($username, $password)
{
    $query = 'SELECT * FROM cliente WHERE email=?';
    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Error en la base de datos");
    }
    $stmt->bind_param('s', $username);

    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res->num_rows == 1) {
            $usuario = $res->fetch_assoc();
            if (!$usuario) {
                return false;
            }
            if ($usuario['suspended'] == 1) {
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
    public function deleteCardFromUser ($idCard, $email) {
        $query = "DELETE FROM comprador_metodos_pago WHERE id_tarjeta=? AND email=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('is', $idCard, $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function selectAllPayOpts($email)
    {
        $table = "comprador_metodos_pago";
        $filter = "email";
        $type = gettype($email);
        try {
            $data = $this->selectAllFrom($table, $filter, $email, $type);
            return $data;
        } catch (Exception $e) {
            throw new Error($e->getMessage());
        }
    }

    public function selectCompDirecciones($email)
    {
        $table = "comprador_direccion";
        $filter = "email";
        $type = gettype($email);

        try {
            $data = $this->selectAllFrom($table, $filter, $email, $type);
            return $data;
        } catch (Exception $er) {
            throw new Error($er->getMessage());
        }
    }

    public function insertPaymentMethod($data) {
        $query = "INSERT INTO comprador_metodos_pago 
                (email, nom_titular, numero, nombre_tarjeta, fecha_ven)
                VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->conn->prepare($query);
        $email = $data['email'];
        $nomTitular = $data['nom_titular'];
        $numer = $data['numero'];
        $nombreTarjeta = $data['nombre_tarjeta'];
        $fechaVen = $data['fecha_ven'];
        $stmt->bind_param('ssiss', $email, $nomTitular, $numer, $nombreTarjeta, $fechaVen);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function addUserDirecciones($data)
    {
        $query = "INSERT INTO comprador_direccion (email, calle_pri, calle_sec, num_puerta, num_apartamento, ciudad, tipo_dir) VALUES (?, ?, ?, ?, ?, ?, ?) ;";
        $stmt = $this->conn->prepare($query);
        $email = $data['email'];
        $callePrimaria = $data['calle_pri'];
        $calleSecundaria = $data['calle_seg'];
        $numPuerta = $data['num_puerta'];
        $numApartamento = $data['num_apartamento'] ?? 'N/A';
        $ciudad = $data['ciudad'];
        $tipoDireccion = $data['tipo_dir'];

        $stmt->bind_param(
            'sssssss',
            $email,
            $callePrimaria,
            $calleSecundaria,
            $numPuerta,
            $numApartamento,
            $ciudad,
            $tipoDireccion
        );

        if ($stmt->execute()) {
            return true;
        } else {
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
        $stmt->bind_param('ssssssi', $callePrimaria, $calleSecundaria, $numPuerta, $numApartamento, $ciudad, $tipoDireccion, $idDireccion);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserProductFavs($userEmail)
    {
        $query = " SELECT *
            FROM productos p
            JOIN favoritos f ON p.sku = f.sku
            JOIN usuario_comprador uc ON f.id_usuario = uc.id_usu_com
            JOIN comprador c ON uc.email = c.email
            WHERE c.email = ?;
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $userEmail);


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
        if (!$stmt) {
            throw new Exception("Error: " . $this->conn->error);
        }
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
    public function createIdComprador($email) {
        $query = "INSERT INTO usuario_comprador (email) values (?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getEmailComprador ($userIdCom) {
        $query = "SELECT * FROM usuario_comprador WHERE id_usu_com=?;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('i', $userIdCom);
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            if ($res->num_rows == 1) {
                return $res->fetch_assoc();
            }
        } else {
            return false;
        }
    }
    public function getIdForComprador($email) {
        $query = "SELECT * FROM usuario_comprador WHERE email =? ;";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                return $result->fetch_assoc();
            }
        } else {
            return false;
        }
    }

    public function addToFav($idUser, $idProd)
    {
        $query = "INSERT into favoritos (sku, id_usuario) VALUES (?, ?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $idProd, $idUser);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserFavorites($idUser)
    {
        $table = "favoritos";
        $filter = "id_usuario";
        $type = gettype($idUser);
        try {
            $data = $this->selectAllFrom($table, $filter, $idUser, $type);
            return $data;
        } catch (Exception $er) {
          
            throw new Error($er->getMessage());
        }

    }
    
    public function deleteFromFavorites($idUser, $idProd)
    {
        $query = "DELETE FROM favoritos WHERE sku=? AND id_usuario=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $idProd, $idUser);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }
}
