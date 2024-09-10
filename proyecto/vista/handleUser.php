<?php
require_once './config/config.php';
require_once './modelo/Usuario.php';
require_once './controlador/UsuarioController.php';

if ($action == 'crear_cuenta') {
    $errors = array();
    $data = [
        'name' => $_POST['name'],
        'lastname' => $_POST['apellido'],
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'confirm_passwd' => $_POST['confirm_passwd'],
        'direccion' => $_POST['direccion'],
        'phone' => $_POST['phone'],
        'fecha_nac' => $_POST['fecha_nac'],
        'terminos' => isset($_POST['terminos']) ? $_POST['terminos'] : 0
    ];
    echo $data;
    $emptyFields = false;
    foreach ($data as $clave => $valor) {
        if (empty(trim($valor))) {
            $emptyFields = true;
            array_push($errors, "El campo $clave es requerido");
        }
    }

    if (!$emptyFields) {
        if ($data['confirm_passwd'] === $data['password']) {
            $data['confirm_passwd'] = password_hash($data['confirm_passwd'], PASSWORD_BCRYPT);
            if (count($errors) === 0) {
                $userController = new UsuarioController();
                $userController->create($data);
                header('Location: /admin');
            } else {
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
            }
        } else {
            array_push($errors, "Las contraseñas no coinciden");
        }
    } else {
        array_push($errors, "Todos los campos son requeridos");
    }
    var_dump($errors);
} else {
    echo "<p>Error en el servidor</p>
    </br> <a href='/'>Volver</a>";
} 