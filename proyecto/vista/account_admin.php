<?php
//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);
include('header-login-admin.php');

?>

<main class="main-form-container">
  <div class="form-login-container">

    <form id="login-form-admin" class="login-form" action="?action=login_adm" method="POST">
      <label for="username">Correo</label>
      <input type="text" name="username" placeholder="Correo electrónico" id="username" required>
      <label for="password">Contraseña</label>
      <input type="password" placeholder="Contraseña" name="password" id="password" required>
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
      <button name="submit" type="button" onclick="adminLoginForm()">Iniciar sesión</button>
      <div class="form-helpers">
        <a href="">
          <span>Olvidé mi contraseña</span>
        </a>
        <a href="/empresa">
          <span>Registrarse</span>
        </a>
      </div>
    </form>

  </div>

  <div class="bg-image"></div>
</main>
<?php

include('footer-ven.php');
