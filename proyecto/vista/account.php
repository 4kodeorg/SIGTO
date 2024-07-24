<?php 
        include('./header.php');
    if (!isset($_SESSION['username'])) {
    ?>
    <main>
      <div class="form-login-container">
        <form class="login-form" action="" method="post">
          <label for="username">Usuario</label>
          <input type="username" name="username" id="username" required>
          <label for="password">Contraseña</label>
          <input type="password" name="psw" id="password" required>
          <button type="submit">Iniciar sesión</button>
        </form>
        <div class="form-helpers">
          <a href="">
            <span>Olvidè mi contraseña</span>
          </a>
          <a href="./register.php">
            <span>Registrarse</span>
          </a>
        </div>
      </div>

      <div class="bg-image"></div>
    </main>
        <?php
    }
    else {
        ?>
        
    <?php
    }
    include('./footer.php')
    ?>

</body>
</html>