<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/modelo/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/controlador/UsuarioController.php';

$errors = array();
if (isset($_POST['submit'])) {
  if (empty(trim($_POST['username'])) || empty(trim($_POST['passwd']))) {
    array_push($errors, "Credenciales inválidas");
  }
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['passwd'];
  if (count($errors) == 0) {
    $userController = new UsuarioController();
    $usuario = $userController->validateUser($username, $password);
    session_start();
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['username'] = $usuario['username'];
    header('Location: /home');
  }
}
include('header.php');
?>

  <main class="main-form-container">
    <div class="form-login-container">

      <form class="login-form" action="account.php" method="post">
        <label for="username">Usuario</label>
        <input type="username" name="username" placeholder="Ingresar usuario" id="username" required>
        <label for="password">Contraseña</label>
        <input type="password" placeholder="Contraseña" name="passwd" id="password" required>
        <?php
        if (count($errors) > 0) {
        foreach ($errors as $err) {
          echo "<p class='errorsp'>" . $err . "</p>";
        }
      }
        ?>
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
</body>

</html>