<?php 
include('header.php')
?>
<div>
        <div class="bg-shopp"></div>
        <form class="registration-form" action="" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="name" id="nombre" required>
            <label for="apellido">Apellido</label>
            <input type="text" name="lastname" id="apellido" required>
            <label for="correo">Correo</label>
            <input type="email" name="email" id="correo" required>
            <label for="usuario">Nombre de usuario</label>
            <input type="text" name="username" id="usuario" required>
            <label for="password">Contraseña</label>
            <input type="password" name="psw" id="password" required>
            <label for="fecha">Fecha de nacimiento</label>
            <input type="date" id="fecha" name="date" required>
            <button type="submit">Crear usuario</button>
        </form>
    </div>

<?php 
include('footer-index.php')
?>