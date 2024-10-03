<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 
include('header.php');
?>
    <div>
        <div class="bg-shopp"></div>
        <form id="registration-form" class="registration-form" action="?action=registrarse" method="POST">
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
            <section id="register-message" class="registration-message">
                <p></p>
                <svg onclick="this.parentElement.style.display=`none`;" 
                    width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor"
                    x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15 15L9 9m6 0l-6 6" />
                            <circle cx="12" cy="12" r="10" />
                        </g>
                    </g>
                </svg>
            </section>
            <div class="buttons-registro">
            <a class="button-registro" href="/cuenta">Ya tienes cuenta?</a>
                <button class="button-registro" type="button" name="submit" onclick="registrationForm()">Crear usuario</button>
                
            </div>
        </form>
    </div>
    <div id="modal-redirect" class='modal-redirect'>
        <div>
            <a class='close-modal' href=#close> </a>
            <p>Cuenta creada con éxito, redirigiendo al inicio..</p>
        </div>
    </div>
    <?php

    include('footer.php');


 