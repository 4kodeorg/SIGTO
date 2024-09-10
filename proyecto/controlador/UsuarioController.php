<?php

require_once '../modelo/Usuario.php';
require_once '../config/Database.php';

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
            $this->createUser($usuario);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function createUser($usuario)
    {
        $query = 'INSERT INTO usuarios (name, lastname, email, username, passw, telefono, fecha_nac, direccion) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            'ssssssss',
            $usuario->getNombre(),
            $usuario->getApellido(),
            $usuario->getEmail(),
            $usuario->getUsername(),
            $usuario->getPassword(),
            $usuario->getTelefono(),
            $usuario->getFechaNac(),
            $usuario->getDireccion()
        );
        error_log("Error: " . $stmt->error);
        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Error al crear usuario");
        }
    }
    public function validateUser($username, $password) {
        
        $query = 'SELECT * FROM usuarios WHERE username=?';
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Error en la base de datos");
        }
        $stmt->bind_param('s', $paramUsername);
        
        $paramUsername = $username;

        if($stmt->execute()) {
            $res = $stmt->get_result();
            if( $res->num_rows == 1 ) {
                $usuario = $res->fetch_assoc();
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
}
