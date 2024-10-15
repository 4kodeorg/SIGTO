<?php
//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);

include('header.php');

?>

<main class="main-form-container">
  <div class="form-login-container">

    <form id="login-form" class="login-form" action="?action=1" method="post">
      <label for="username">Usuario</label>
      <input type="text" name="username" placeholder="Correo electrónico" id="username" required>
      <label for="password">Contraseña</label>
      <input type="password" placeholder="Contraseña" name="passwd" id="password" required>
      <section id="login-message" class="container-mssg-login">
        <p></p>
        <svg onclick="this.parentElement.style.display=`none`" ;
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
      <button name="submit" type="button" onclick="loginForm()">Iniciar sesión</button>
      <a class="button-action-google" href="<?php echo $client->createAuthUrl() ?>">
        Continuar con google <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="38px" height="38px" viewBox="0 0 48 48">
          <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
          <path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
          <path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
          <path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
        </svg>
      </a>
      <div class="form-helpers">
        <a href="">
          <span>Olvidé mi contraseña</span>
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

include('footer.php');
