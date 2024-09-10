    <?php
    require_once '../config/config.php';
    require_once '../modelo/Usuario.php';
    require_once '../controlador/UsuarioController.php';

    if (isset($_POST['submit'])) {
        $errors = array();
        $data = [
            'name' => $_POST['name'],
            'lastname' => $_POST['apellido'],
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['psw'],
            'confirm_passwd' => $_POST['confirm_passwd'],
            'direccion' => $_POST['direccion'],
            'phone' => $_POST['phone'],
            'fecha_nac' => $_POST['fecha_nac'],
            'terminos' => isset($_POST['terminos']) ? $_POST['terminos'] : 0
        ];
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
                    session_start();
                    echo "<div class='modal-redirect'>
                    <div>
                    <a class='close-modal' href=#close> </a>
                    <p>Cuenta creada con éxito, redirigiendo al inicio..</p> 
                    </div>
                    </div>";
                    header('refresh:5; url=/');
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
    } 
    include('header.php')
    ?>
    <div>
        <div class="bg-shopp"></div>
        <form class="registration-form" action="register.php" method="POST">
            <!-- <input type="hidden" name="action" value="crear_cuenta"> -->
            <div class="container-inputs">
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Nombre" name="name" id="nombre" required>
            </div>
            <div class="container-inputs">
                <label for="apellido">Apellido</label>
                <input type="text" placeholder="Apellido" name="apellido" id="apellido" required>
            </div>
            <div class="container-inputs">
                <label for="correo">Correo</label>
                <input type="email" placeholder="alguien@example.com" name="email" id="correo" required>
            </div>
            <div class="container-inputs">
                <label for="usuario">Nombre de usuario</label>
                <input type="text" placeholder="Nombre de usuario" name="username" id="usuario" required>
            </div>
            <div class="container-inputs">
                <label for="password">Contraseña</label>
                <input type="password" placeholder="Contraseña" name="psw" id="password" required>
            </div>
            <div class="container-inputs">
                <label for="passwd">Repetir contraseña</label>
                <input type="password" placeholder="Confirmar contraseña" name="confirm_passwd" id="passwd">
            </div>
            <div class="container-inputs">
                <label for="telefono">Número de celular</label>
                <input type="tel" name="phone" id="telefono">
            </div>
            <div class="container-inputs">

                <label for="fecha">Fecha de nacimiento</label>
                <input type="date" id="fecha" name="fecha_nac" required>
            </div>
            <div class="container-inputs">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" placeholder="Ingrese su dirección" name="direccion" required>
            </div>
            <div class="container-inputs">
                <label for="terminos">Acepto los términos y condiciones</label>
                <input type="checkbox" name="terminos" id="terminos" value="1">

            </div>
            <div class="buttons-registro">
                <button class="button-registro" name="submit">Crear usuario</button>
                <a class="button-registro" href="/cuenta">Ya tienes cuenta?</a>
            </div>
        </form>
    </div>
    <?php

    include('footer.php')
    ?>