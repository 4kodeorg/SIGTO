<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/cfg.php';
$usId = isset($_SESSION['id_username']) ? $_SESSION['id_username'] : 0;
$idComprador = isset($_SESSION['id_comprador']) ? $_SESSION['id_comprador'] : 0;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$favoritos = isset($data['favoritos']) ? $data['favoritos'] : [];

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

  <script src="https://sandbox.paypal.com/sdk/js?client-id=<?php echo PAYPAL_CLIENT_ID ?>&components=buttons">
  </script>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mercado Ya!</title>
</head>

<div id="userId" data-user-id="<?php echo $idComprador ?>"></div>

<body>
  <div class="container-fluid navigation">
    <nav class="navbar navbar-expand-lg bg-body-tertiary py-4">
      <div class="container-fluid px-4">
        <div class="brand-container">
          <a href="/home" class="navbar-brand">
            <h1 class="logo">Mercado Ya</h1>
          </a>
          <div class="search-form-container">
            <form class="searchbar2" role="search" action="/home?action=search" method="get" id="search-form">
            <label for="acategory"></label>  
            <select name="acategory" id="acategory">
                <option value="">Todas las categorías</option>
                <?php
                if (isset($data['categorias']) && !empty($data['categorias'])) {
                  foreach ($data['categorias'] as $cate) {
                    echo '<option value="'. $cate['id_categoria']. '">
                    ' . $cate['nombre'] . ' </option>';
                  }
                }
                ?>
              </select>
              <label for="busqueda"></label>
              <input type="text" id="busqueda" name="buscar" autocomplete="off" placeholder="Buscar cualquier artículo">

              <button class="searchbtn" type="submit">
                <svg width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor"
                  x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                  <g fill="currentColor">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                      d="m42.501 42.5l-7.351-7.776a17.244 17.244 0 1 0-7.075 4.422" />
                  </g>
                </svg>
              </button>
              <!-- PARA IMPLEMENTAR, BUSQUEDA EN VIVO, PUEDE QUE NO.. -->
              <div id="autocomplete-search">
                <a href=""></a>
              </div>
            </form>

          </div>
        </div>

        <ul class="ul-for-nav">
          <?php
          if (isset($username) && !empty(trim($username)) && $usId != 0) {
          ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">Hola <?php echo ucfirst($username) ?></a>
              <ul class="dropdown-menu drodown-menu-end">
                <li><a class="dropdown-item" href="/perfil/<?php echo $usId ?>">Mi perfil </a> </li>
                <li><a class="dropdown-item" href="/perfil/<?php echo $usId ?>/favoritos">Favoritos </a> </li>
                <li><a class="dropdown-item" href="/perfil/<?php echo $usId ?>/compras">Historial de compra </a> </li>
                <hr class="dropdown-divider">
                <li><a class="dropdown-item" href="/logout" onclick="sessionStorage.clear();"> Cerrar sesión</a> </li>
              </ul>
            </li>
          <?php } else { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Mi cuenta
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/registro">Registrate</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/cuenta">Inicia sesión</a></li>
                  <hr class="dropdown-divider">
                 <li><a href="/empresa" class="dropdown-item">Registrar mi empresa</a></li> 
              </ul>
            </li>
          <?php }
          ?>
          <li class="nav-item">
            <a href="" class="nav-link">Ayuda</a>
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
        <button id="cart"
          class="btn btn-primary"
          data-bs-toggle="offcanvas"
          href="#offcanvasCarrito"
          role="button"
          aria-controls="offcanvasCarrito">

          <section id="items-cart" class="circle"><small>0 </small>
          </section>

          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB6ElEQVR4nO2ZO0tcQRSAv1VBCVhrwG0Eo65CCGLjL1DE1s4gGBFlEVkQ7PILUgQCFjYW4qrrAxG1CiL2NilEsPKBibj4wELwFQZOsYTsLi5zZu4sfnCaYQ57vnvnzs5h4I3o0QucAi8F4grYBT4DMSLKSRGJf2M2qjInOUUe55lTBwwBdzLPvJnI0SMyRqK7yNwvIrJP4FQDlyLTRuDMiUiSwBkWkQyB80FELqK6e72GM5FJEDjzIjJG4IyIyCKB0yIif8rpO2khcBZeeUbTiB0bIqMREDmyIZKIgMhXGyLmI//tUeIZaMQSGY8iP7FI0qPIgE2Rdk8SN8A7myIx+VN0LTKDAiseRLo0RMYdSxxqHYs+OhaZQolYTh+vHU9AHEXWHIlso8yEI5F+bZFPDiSyQI22SIX8kKbIDxyxrizS4UokpSjxC4d0KIqkXIpUyj2KbYkHoB7HbCg0T9/xwKQUME3gdIrIAYFTJU2PWRLvCZwNeSuDlMn9yS6BU5tzrP8GtLo4I2nRB9xb3Ib3fMvYEnkEGnxfmm5KESa2ZCydJyddQo4651JA7pOMy5g58v+PbIEcs6174bZAUdcWc9RZlQK2pJi49NxmbNlijjrNebpGM9ZkMQcXmCWyJOvbhHmqxQoqJYe/S/viCgHGEU4AAAAASUVORK5CYII=">

          <section class="section-price-cart">
            <span>$</span><b>0</b>
          </section>
        </button>
      </div>

    </nav>
  </div>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCarrito" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Mi carrito</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div id="offcanvas-carrito" class="offcanvas-body">

    </div>
  </div>
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar-menu" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Mercado Ya &copy;</h5>
    </div>
    <div class="offcanvas-body">
      <ul class="ul-sidebar-menu">
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
          <?php
          if (isset($username) && !empty(trim($username)) && $usId != 0) {
            echo '<p class="logo">Hola ' . ucfirst($username) . '</p>';

          ?>
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
          <?php
            echo '
            <a href="/perfil/' . $usId . '" class="menu-normal-actions">
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
            Mi perfil</a>
            <a href="/perfil/' . $usId . '" class="menu-normal-actions">
            <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79" />
                    </svg>
            Mis favoritos</a>
            <a href="/perfil/' . $usId . '" class="menu-normal-actions">
            <svg width="28px" height="28px" viewBox="0 0 32 32" fill="currentColor" x="217" y="217" role="img" xmlns="http://www.w3.org/2000/svg">
              <g fill="currentColor">
                <path fill="currentColor" d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2Zm0 26a12 12 0 1 1 12-12a12 12 0 0 1-12 12Z" />
                <circle cx="16" cy="23.5" r="1.5" fill="currentColor" />
                <path fill="currentColor" d="M17 8h-1.5a4.49 4.49 0 0 0-4.5 4.5v.5h2v-.5a2.5 2.5 0 0 1 2.5-2.5H17a2.5 2.5 0 0 1 0 5h-2v4.5h2V17a4.5 4.5 0 0 0 0-9Z" />
              </g>
            </svg>
            Ayuda</a>
            <a href="/logout" onclick="sessionStorage.clear();" class="menu-normal-actions">
            <svg width="28px" height="28px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" d="M12 18.25a.75.75 0 0 0 0 1.5h6A1.75 1.75 0 0 0 19.75 18V6A1.75 1.75 0 0 0 18 4.25h-6a.75.75 0 0 0 0 1.5h6a.25.25 0 0 1 .25.25v12a.25.25 0 0 1-.25.25h-6Z"/><path fill="currentColor" fill-rule="evenodd" d="M14.503 14.365c.69 0 1.25-.56 1.25-1.25v-2.24c0-.69-.56-1.25-1.25-1.25H9.89a26.723 26.723 0 0 0-.02-.22l-.054-.556a1.227 1.227 0 0 0-1.751-.988a15.059 15.059 0 0 0-4.368 3.163l-.099.104a1.253 1.253 0 0 0 0 1.734l.1.103a15.06 15.06 0 0 0 4.367 3.164a1.227 1.227 0 0 0 1.751-.988l.054-.556l.02-.22h4.613Zm-5.308-1.5a.75.75 0 0 0-.748.704c-.019.29-.042.581-.07.871l-.016.162a13.562 13.562 0 0 1-3.516-2.607a13.558 13.558 0 0 1 3.516-2.607l.016.162c.028.29.051.58.07.871a.75.75 0 0 0 .748.704h5.058v1.74H9.195Z" clip-rule="evenodd"/></g>
            </svg>
            Cerrar sesión</a>
            ';
          } else {
          ?>
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
              <a href="/empresa" class="menu-normal-action">
              <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M18 19h-2.5q-.213 0-.356-.144T15 18.499t.144-.356T15.5 18H18v-2.5q0-.213.144-.356t.357-.144t.356.144t.143.356V18h2.5q.213 0 .356.144t.144.357t-.144.356T21.5 19H19v2.5q0 .213-.144.356t-.357.144t-.356-.144T18 21.5zm-13.961.5q-.344 0-.576-.232t-.232-.576V13.5h-.445q-.378 0-.63-.305t-.152-.684l1-4.384q.061-.274.288-.45q.226-.177.514-.177h12.388q.288 0 .514.176q.227.177.288.451l1 4.384q.1.38-.152.684t-.63.305h-.445v2.77q0 .212-.144.356t-.356.143t-.356-.143t-.144-.357V13.5h-4.538v5.192q0 .344-.232.576t-.576.232zm.192-1h6v-5h-6zm-.577-13q-.213 0-.357-.144t-.143-.357t.143-.356t.357-.143h12.692q.213 0 .356.144t.144.357t-.144.356t-.356.143z"/>
            </svg>
            Registrar mi empresa
              </a>

            <a href="/registro" class="menu-normal-actions">
            <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
            <path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4"/>
            </svg>
            Regístrate</a>
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
      <?php
          }
      ?>
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