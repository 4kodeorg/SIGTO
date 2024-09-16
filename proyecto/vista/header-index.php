<?php
session_start();
// if (isset($_SESSION['username'])) {
// $username = $_SESSION['username'];
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="../assets/index.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mercado Ya!</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary px-4 py-4">
    <div class="container-fluid px-4">
      <div class="brand-container">
        <a href="/" class="navbar-brand">
          <h1 class="logo">Mercado Ya</h1>
        </a>
        <div class="search-form-container">
        <form class="searchbar2" role="search" action="?=search" method="post">
        <select name="acategory" id="">
            <option value="0">Todas las categorías</option>
          </select>
          <label for="busqueda"></label>
          <input type="text" id="busqueda" name="buscar" placeholder="Buscar cualquier artículo">
          
          <div class="searchbtn" type="submit">
            <svg width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor"
              x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
              <g fill="currentColor">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                  d="m42.501 42.5l-7.351-7.776a17.244 17.244 0 1 0-7.075 4.422" />
              </g>
            </svg>
          </div>
        </form>
        </div>
      </div>

      <ul class="ul-for-nav">
        <?php
        if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo '<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" 
        aria-expanded="false">Hola '. ucfirst($username) .' </a>
        <ul class="dropdown-menu drodown-menu-end">
        <li><a class="dropdown-item" href="/perfil">Mi perfil </a> </li>
        <li><a class="dropdown-item" href="/perfil">Favoritos </a> </li>
        <li><a class="dropdown-item" href="/perfil">Historial de compra </a> </li>
        <hr class="dropdown-divider">
        <li><a class="dropdown-item" href="/logout"> Cerrar sesión</a> </li>
        </ul>
        </li>';

        ?>
        <?php
        } else { 
          echo '<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Mi cuenta
        </a>
        <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="/registro">Registrate</a></li>
        <li>
        <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="/cuenta">Inicia sesión</a></li>

        </ul>
        </li>'; 
      }
        ?>
        <li class="nav-item">
          <a href="" class="nav-link">Ayuda</a>
        </li>
        <li class="nav-item">
          <a href="/carrito" class="nav-link message">
            <div class="circle"></div>
            <svg
              width="32px" height="32px" viewBox="0 0 1024 1024" fill="currentColor" x="128" y="128" role="img"
              xmlns="http://www.w3.org/2000/svg">
              <g fill="currentColor">
                <path fill="currentColor" d="M922.9 701.9H327.4l29.9-60.9l496.8-.9c16.8 0 31.2-12 34.2-28.6l68.8-385.1c1.8-10.1-.9-20.5-7.5-28.4a34.99 34.99 0 0 0-26.6-12.5l-632-2.1l-5.4-25.4c-3.4-16.2-18-28-34.6-28H96.5a35.3 35.3 0 1 0 0 70.6h125.9L246 312.8l58.1 281.3l-74.8 122.1a34.96 34.96 0 0 0-3 36.8c6 11.9 18.1 19.4 31.5 19.4h62.8a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7h161.1a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7H923c19.4 0 35.3-15.8 35.3-35.3a35.42 35.42 0 0 0-35.4-35.2zM305.7 253l575.8 1.9l-56.4 315.8l-452.3.8L305.7 253zm96.9 612.7c-17.4 0-31.6-14.2-31.6-31.6c0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6zm325.1 0c-17.4 0-31.6-14.2-31.6-31.6c0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6z" />
              </g>
            </svg>
          </a>
        </li>

      </ul>

      <a class="" id="burger-menu" data-bs-toggle="offcanvas" href="#sidebar-menu" role="button" aria-controls="offcanvasExample">
        <svg width="42px" height="42px"
          viewBox="0 0 32 32" fill="currentColor" x="217" y="217" role="img"
          xmlns="http://www.w3.org/2000/svg">
          <g fill="currentColor">
            <path fill="none"
              stroke="currentColor" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2"
              d="M4 8h24M4 16h24M4 24h24" />
          </g>
        </svg>
      </a>

      <a href="/carrito" id="cart-responsive" class="message">
        <div id="counter" class="circle"></div>
        <svg
          width="40px" height="40px" viewBox="0 0 1024 1024" fill="currentColor" x="128" y="128" role="img"
          xmlns="http://www.w3.org/2000/svg">
          <g fill="currentColor">
            <path fill="currentColor" d="M922.9 701.9H327.4l29.9-60.9l496.8-.9c16.8 0 31.2-12 34.2-28.6l68.8-385.1c1.8-10.1-.9-20.5-7.5-28.4a34.99 34.99 0 0 0-26.6-12.5l-632-2.1l-5.4-25.4c-3.4-16.2-18-28-34.6-28H96.5a35.3 35.3 0 1 0 0 70.6h125.9L246 312.8l58.1 281.3l-74.8 122.1a34.96 34.96 0 0 0-3 36.8c6 11.9 18.1 19.4 31.5 19.4h62.8a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7h161.1a102.43 102.43 0 0 0-20.6 61.7c0 56.6 46 102.6 102.6 102.6s102.6-46 102.6-102.6c0-22.3-7.4-44-20.6-61.7H923c19.4 0 35.3-15.8 35.3-35.3a35.42 35.42 0 0 0-35.4-35.2zM305.7 253l575.8 1.9l-56.4 315.8l-452.3.8L305.7 253zm96.9 612.7c-17.4 0-31.6-14.2-31.6-31.6c0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6zm325.1 0c-17.4 0-31.6-14.2-31.6-31.6c0-17.4 14.2-31.6 31.6-31.6s31.6 14.2 31.6 31.6a31.6 31.6 0 0 1-31.6 31.6z" />
          </g>
        </svg>
      </a>
    </div>

  </nav>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar-menu" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Mercado Ya &copy;</h5>
    </div>
    <div class="offcanvas-body">
      <ul>
        <div class="business-logo">
          <svg
            width="40px" height="40px" viewBox="0 0 48 48" fill="currentColor"
            x="226" y="226" role="img" xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor">
              <circle cx="13.856" cy="37.551" r="3.051"
                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <circle cx="31.755" cy="37.551" r="3.051" fill="none" stroke="currentColor"
                stroke-linecap="round" stroke-linejoin="round" />
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.805h4.678L13.856 34.5h17.899" />
              <circle cx="37.5" cy="16.703" r="6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M41.161 9.28L40.1 11.299m-7.583-2.375l4.017-1.526m.966 9.305l-1.271-3.661m-26.155 2.302l18.07.902M13.031 30.323h20.91c3.254 0 3.56-4.416 3.56-4.416m-26.345-5.084l18.005.508m-17.098 4.09l23.075.441m-4.604 4.461l.966-6.603m-6.763 6.603l-.153-14.255m-6.965-.347l1.49 14.602" />
            </g>
          </svg>

          <h2 class="logo">Mercado Ya!</h2>
        </div>
        <div class="menu-normal">
          <a href="/" class="menu-normal-actions active">
            <svg
              width="28px" height="28px" viewBox="0 0 16 16"
              fill="currentColor" x="128" y="128" role="img"
              xmlns="http://www.w3.org/2000/svg">
              <g fill="currentColor">
                <path fill="currentColor"
                  fill-rule="evenodd" d="m8.36 1.37l6.36 5.8l-.71.71L13 6.964v6.526l-.5.5h-3l-.5-.5v-3.5H7v3.5l-.5.5h-3l-.5-.5V6.972L2 7.88l-.71-.71l6.35-5.8h.72zM4 6.063v6.927h2v-3.5l.5-.5h3l.5.5v3.5h2V6.057L8 2.43L4 6.063z" clip-rule="evenodd" />
              </g>
            </svg>
            Inicio</a>
          <a href="/cuenta" class="menu-normal-actions">
            <svg width="28px" height="28px" viewBox="0 0 32 32"
              fill="currentColor" x="217" y="217" role="img"
              xmlns="http://www.w3.org/2000/svg">
              <g fill="currentColor">
                <path fill="none"
                  stroke="currentColor" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2"
                  d="M22 11c0 5-3 9-6 9s-6-4-6-9s2-8 6-8s6 3 6 8ZM4 30h24c0-9-6-10-12-10S4 21 4 30Z" />
              </g>
            </svg>
            Mi cuenta</a>

          <a href="/registro" class="menu-normal-actions">Regístrate</a>
          <a class="menu-normal-actions">
            <svg width="28px" height="28px" viewBox="0 0 32 32" fill="currentColor" x="217" y="217" role="img" xmlns="http://www.w3.org/2000/svg">
              <g fill="currentColor">
                <path fill="currentColor" d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2Zm0 26a12 12 0 1 1 12-12a12 12 0 0 1-12 12Z" />
                <circle cx="16" cy="23.5" r="1.5" fill="currentColor" />
                <path fill="currentColor" d="M17 8h-1.5a4.49 4.49 0 0 0-4.5 4.5v.5h2v-.5a2.5 2.5 0 0 1 2.5-2.5H17a2.5 2.5 0 0 1 0 5h-2v4.5h2V17a4.5 4.5 0 0 0 0-9Z" />
              </g>
            </svg>
            Ayuda</a>
        </div>
        <a class="opinions">
          <svg width="28px" height="28px" viewBox="0 0 32 32"
            fill="currentColor" x="217" y="217" role="img"
            xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor">
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 4h28v18H16l-8 7v-7H2Z" />
            </g>
          </svg>
          Dejanos tu opinión</a>

      </ul>
      <div class="container">

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

      </div>
    </div>
  </div>