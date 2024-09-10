<?php

class Usuario {

    private int $id;
    private string $nombre;
    private string $username;
    private string $apellido;
    private string $password;
    private string $email;
    private string $fecha_nac;
    private int $telefono;
    private string $direccion;
    private string $seg_direccion;

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getFechaNac() {
        return $this->fecha_nac;
    }
    public function setFechaNac($fecha_nac) {
        $this->fecha_nac = $fecha_nac;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function getSegDireccion() {
        return $this->seg_direccion;
    }
    public function setSegDireccion($seg_direccion) {
        $this->seg_direccion = $seg_direccion;
    }

}
?>