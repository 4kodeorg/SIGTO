<?php

class Vendedor
{
    private string $email;
    private int $razon_social;
    private string $password;
    private string $fecha_registro;
    private string $nombre;
    private string $apellido;
    private string $fecha_nac;


    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRazonSocial( $razon_social)
    {
        $this->razon_social = $razon_social;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido( $apellido)
    {
        $this->apellido = $apellido;
    }

    public function setFechaNac( $fecha_nac)
    {
        $this->fecha_nac = $fecha_nac;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function getRazonSocial()
    {
        return $this->razon_social;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getFechaNac()
    {
        return $this->fecha_nac;
    }
}
