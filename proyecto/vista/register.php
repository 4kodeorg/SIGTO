    <?php
    include('header.php')
    ?>
    <div>
        <div class="bg-shopp"></div>
        <form class="registration-form" action="" method="post">

            <div class="container-inputs">
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Nombre" name="name" id="nombre" required>
            </div>
            <div class="container-inputs">
                <label for="apellido">Apellido</label>
                <input type="text" placeholder="Apellido" name="lastname" id="apellido" required>
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
                <input type="password" placeholder="Confirmar contraseña" name="passwd" id="passwd">
            </div>
            <div class="container-inputs">
                <label for="fecha">Fecha de nacimiento</label>
                <input type="date" id="fecha" name="date" required>
            </div>

            <div class="buttons-registro">
                <button class="button-registro" type="submit">Crear usuario</button>
                <a class="button-registro" href="/cuenta">Ya tienes cuenta?</a>
            </div>
        </form>
    </div>

    <?php
    include('footer.php')
    ?>