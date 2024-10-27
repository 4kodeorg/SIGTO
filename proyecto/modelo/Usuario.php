<?php

class Usuario {

    private string $nombre;
    private string $username;
    private string $nombre2;
    private string $apellido;
    private string $apellido2;
    private string $password;
    private string $email;
    private string $fecha_registro;
    private string $fecha_nac;
    private string $telefono;
    private string $direccion;
    private string $pais;
    private string $seg_direccion;

  
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function setNombreDos($nombre2) {
        $this->nombre2 = $nombre2;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function setApellidoDos($apellido2) {
        $this->apellido2 = $apellido2;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setFechaRegistro($fecha_registro) {
        $this->fecha_registro = $fecha_registro;
    }
    public function setPais($pais) {
        $this->pais = $pais;
    }
    public function setFechaNac($fecha_nac) {
        $this->fecha_nac = $fecha_nac;
    }
    public function setEmail($email) {
        $this->email = $email;
    }
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function setSegDireccion($seg_direccion) {
        $this->seg_direccion = $seg_direccion;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getNombreDos() {
        return $this->nombre2;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getApellidoDos() {
        return $this->apellido2;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getFechaRegistro() {
        return $this->fecha_registro;
    }
    public function getPais() {
        return $this->pais;
    }
    public function getFechaNac() {
        return $this->fecha_nac;
    }
    public function getTelefono() {
        return $this->telefono;
    }
    public function getDireccion() {
        return $this->direccion;
    }
    public function getSegDireccion() {
        return $this->seg_direccion;
    }

}
?>