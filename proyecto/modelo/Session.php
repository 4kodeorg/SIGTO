<?php

class Session {
    private string $email;
    private string $fecha_ini_sess;


public function setEmail($email) {
    $this->email = $email;
}
public function setFechaInit($fecha_ini_sess) {
    $this->fecha_ini_sess = $fecha_ini_sess;
}
public function getEmail() {
    return $this->email;
}
public function getFechaInit() {
    return $this->fecha_ini_sess;
}

}