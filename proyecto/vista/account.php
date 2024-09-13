<?php

include('header.php');
?>

  <main class="main-form-container">
    <div class="form-login-container">

      <form class="login-form" action="?action=1" method="post">
        <label for="username">Usuario</label>
        <input type="username" name="username" placeholder="Ingresar usuario" id="username" required>
        <label for="password">Contraseña</label>
        <input type="password" placeholder="Contraseña" name="passwd" id="password" required>
     
        <button name="submit" type="submit">Iniciar sesión</button>

        <div class="form-helpers">
          <a href="">
            <span>Olvidè mi contraseña</span>
          </a>
          <a href="/registro">
            <span>Registrarse</span>
          </a>
        </div>
      </form>

    </div>

    <div class="bg-image"></div>
  </main>
<?php

include('footer.php')
?>
