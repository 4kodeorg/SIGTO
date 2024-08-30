<?php

require_once 'modelo/Usuario.php';

class UsuarioController {
    public function create($data) {
        $usuario = new Usuario();
        $usuario->setNombre($data['nombre']);
        $usuario->setCorreo($data['correo']);
        $usuario->setCelular($data['phone']);
        $usuario->setDireccion($data['direccion']);

        try {
            $usuario->createNew();
        } catch (Exception $e) {
            $e->getMessage();
        }
    
    }
}


?>