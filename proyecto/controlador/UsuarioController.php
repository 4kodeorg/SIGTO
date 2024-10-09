<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/modelo/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/Database.php';

class UsuarioController extends Database
{
    public function create($data)
    {
        $usuario = new Usuario();
        $usuario->setNombre($data['name']);
        $usuario->setApellido($data['lastname']);
        $usuario->setEmail($data['email']);
        $usuario->setUsername($data['username']);
        $usuario->setTelefono($data['phone']);
        $usuario->setDireccion($data['direccion']);
        $usuario->setFechaNac($data['fecha_nac']);
        $usuario->setPassword($data['confirm_passwd']);
        try {
            return $this->createUser($usuario);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function createUser($usuario)
    {
        $query = "INSERT INTO usuarios (name, lastname, email, username, passw, telefono, fecha_nac, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $this->conn->prepare($query);

        $name = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $email = $usuario->getEmail();
        $username = $usuario->getUsername();
        $passw = $usuario->getPassword();
        $telefono = $usuario->getTelefono();
        $fecha_nac = $usuario->getFechaNac();
        $direccion = $usuario->getDireccion();

        $stmt->bind_param(
            'ssssssss', $name, $apellido, $email, $username, $passw, $telefono, $fecha_nac, $direccion
        );
        error_log("Error: " . $stmt->error);
        if ($stmt->execute()) {
            $query = "SELECT * FROM usuarios WHERE id=".$this->conn->insert_id.";";
            $stmtn = $this->conn->prepare($query);
            if($stmtn->execute()) {
                $res = $stmtn->get_result();
                if( $res->num_rows == 1 ) {
                    return $res->fetch_assoc();
                }
        } else {
            throw new Exception("Error al crear usuario");
        }
    }
    }
    public function validateUser($username, $password) {
        
        $query = 'SELECT * FROM usuarios WHERE username=?';
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la base de datos");
        }
        $paramUsername = $username;
        $stmt->bind_param('s', $paramUsername);

        if($stmt->execute()) {
            $res = $stmt->get_result();
            if( $res->num_rows == 1 ) {
                $usuario = $res->fetch_assoc();
                if (!$usuario) {
                    return false;
                }
                $passwd = $usuario['passw'];
                if (password_verify($password, $passwd)) {
                    return $usuario;
                }
                else {
                    return false;
                }
            }
            else {
                return false;
            }
        } else {
            throw new Exception("Error en el servidor");
        }
        
    }
    public function updateUserDireccion($idUser, $direccionEnvio, $segDireccionEnvio) {
        $query = "UPDATE usuarios SET direccion =?, seg_direccion= ? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssi',$direccionEnvio,$segDireccionEnvio, $idUser);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getUserProductFavs($userId) {
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
    
    public function updateUserData($idUser, $newEmail, $newPhone, $newUser) {
        $query = "UPDATE usuarios SET email=?, username=?, telefono=? WHERE id=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssii', $newEmail, $newUser, $newPhone, $idUser);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserbyId($idUser) {
        $query = "SELECT * FROM usuarios WHERE id = ?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idUser);
         if ($stmt->execute()) {
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();
            $stmt->close();
            return $usuario;
         }
        else {
            throw new Exception("Error en la base datos");
            }
        }

    public function addToFav($idUser, $idProd) {
        $query = "INSERT into favoritos (id_user, id_prod) VALUES (?, ?);";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $idUser, $idProd);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function getUserFavorites ($idUser) {
        $query = "SELECT * FROM favoritos WHERE id_user=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $idUser);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
            $favoritos = $result->fetch_all(MYSQLI_ASSOC); 
            }
            else {
                $favoritos = [];
            }
            $stmt->close();
            return $favoritos;
        }
        else {
            throw new Exception("Error en la base de datos");
        }
    }
    public function deleteFromFavorites ($idUser, $idProd) {
        $query = "DELETE FROM favoritos WHERE id_user=? AND id_prod=?;";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $idUser, $idProd);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        else {
            $stmt->close();
            return false;
        }
    }

}