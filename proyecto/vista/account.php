<?php 
        include('header.php');
    if (!isset($_SESSION['username'])) {
    ?>
    <main class="main-form-container">
      <div class="form-login-container">
        <form class="login-form" action="" method="post">
          <label for="username">Usuario</label>
          <input type="username" name="username" placeholder="Ingresar usuario" id="username" required>
          <label for="password">Contraseña</label>
          <input type="password" placeholder="Contraseña" name="psw" id="password" required>
          <button type="submit">Iniciar sesión</button>

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
    }
    else {
        ?>
        
    <?php
    }
    include('footer.php')
    ?>

</body>
</html>