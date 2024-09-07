<?php
// session_start();
// if(isset($_SESSION['username'])) 
// {

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../../assets/backstyle.css">
    <!-- <script src="../../assets/main.js" defer></script> -->
    <link rel="stylesheet" href="../../assets/backresponsive.css">
</head>

<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary py-4">
    <div class="container-fluid px-4" >
    <div class="container-mobile">
    <a href="/"> <h2 class="logo px-3">Mercado Ya!</h2> </a>
    <form class="d-flex searchbar2">
        <input type="text" placeholder="Buscar">
        <div class="searchbtn">
            <svg width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor" 
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                 d="m42.501 42.5l-7.351-7.776a17.244 17.244 0 1 0-7.075 4.422"/></g>
            </svg>
        </div>
    </form>
    </div>
    <div class="header-options">
    <small>Notificaciones</small>
            <svg class="p-1" width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor" 
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="none" 
                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                d="M40.462 32.173c-2.53-1.967-2.918-2.596-4.611-11.571c-1.438-7.623-4.59-9.993-8.504-11.232c.217-.47.347-.99.347-1.543a3.694
                3.694 0 0 0-7.388 0c0 .553.13 1.072.347 1.543c-3.913 1.24-7.066 3.61-8.504 11.232c-1.693 8.975-2.08 9.604-4.61 11.57c-2.614
                2.032-2.53 6.71.948 6.71h10.464c.04 2.76 2.281 4.985 5.049 4.985s5.01-2.226 5.049-4.984h10.463c3.479 0 3.563-4.68.95-6.71Z"/></g>
            </svg>
            
            <small>Perfil</small>
            <svg class="p-1" width="36px" height="36px" viewBox="0 0 1200 1200" fill="currentColor" x="128" y="128" role="img"
                xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" d="M605.096 
                480c-135.542-2.098-239.082-111.058-239.999-240C367.336 105.667 477.133.942 605.096 0c135.662 5.13 
                239.036 108.97 240.001 240c-2.668 134.439-111.907 239.09-240.001 240zm194.043 49.788c170.592 1.991 
                257.094 151.63 257.881 301.269V1200H889.784l.001-324.254c-4.072-22.416-19.255-30.018-33.164-27.82c-13.022
                2.059-24.929 12.701-25.56 27.82V1200h-464.67V875.746c-3.557-21.334-17.128-29.537-30.331-28.709c-14.138.889-27.853
                12.135-28.393 28.709V1200h-164.68V831.057c-.98-159.475 99.901-300.087 259.137-301.269h397.015z"/></g>
        </svg>
    </div>

</div>
</nav>
<button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
<svg width="40px" height="40px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" d="M4 11h12v2H4zm0-5h16v2H4zm0 12h7.235v-2H4z"/></g>
</svg>
</button>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Mercado Ya!</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">

  <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="/general" class="nav-option option1 active">
                        <svg width="36px" height="36px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="m1 2l1-1h12l1 1v12l-1 1H2l-1-1V2Zm1 
                    0v12h3V2H2Zm4 0v8h8V2H6Z" />
                            </g>
                        </svg>
                        <h3> Panel</h3>
                    </a>

                    <a href="/productos" class="nav-option option2">
                    <svg width="36px" height="36px" viewBox="0 0 24 24" 
                        fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor"><g fill="none" stroke="currentColor" stroke-linejoin="round" 
                        stroke-width="2"><path stroke-linecap="round" d="M11.029 2.54a2 2 0 0 1 1.942 0l7.515
                        4.174a1 1 0 0 1 .514.874v8.235a2 2 0 0 1-1.029 1.748l-7 3.89a2 2 0 0 1-1.942 0l-7-3.89A2
                        2 0 0 1 3 15.824V7.588a1 1 0 0 1 .514-.874L11.03 2.54Z"/><path stroke-linecap="round" 
                        d="m7.5 4.5l9 5V13M6 12.328L9 14"/><path d="m3 7l9 5m0 0l9-5m-9 5v10"/></g></g>
                    </svg>
                    <h3>Productos</h3>
                    </a>

                    <a href="/estadisticas" class="nav-option option3">
                        <svg width="36px" height="36px" viewBox="0 0 36 36" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="M32 5H4a2 2 0 0 0-2 2v22a2 2 0 0 0 2 2h28a2 2 0 0 0
                        2-2V7a2 2 0 0 0-2-2ZM4 29V7h28v22Z" class="clr-i-outline clr-i-outline-path-1" />
                                <path fill="currentColor" d="m15.62 15.222l-6.018 8.746l-4.052-3.584l1.06-1.198l2.698 
                        2.386l6.326-9.192l6.75 10.015l6.754-8.925l1.276.966l-8.106 10.709z" class="clr-i-outline clr-i-outline-path-2" />
                                <path fill="none" d="M0 0h36v36H0z" />
                            </g>
                        </svg>
                        <h3>Estadísticas</h3>
                    </a>

                    <a href="/empresa" class="nav-option option4">
                        <svg width="36px" height="36px" viewBox="0 0 512 512" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                            <path fill="currentColor" d="M393.674 430.14V448H54.326l.004-17.86zm-13.395-26.791v22.325H67.721V403.35zM100.452
                            162.233l3.726 1.883l1.864 30.11l1.865 48.928v47.055l-1.865 58.656l-.31 39.515l-5.28 
                            1.573H81.816l-5.59-1.573l-2.172-39.515l-1.868-58.343v-47.051l1.868-49.244l1.704-30.273l3.887-1.721zm267.909
                            0l3.73 1.883l1.861 30.11l1.862 48.928v47.055l-1.862 58.656l-.306 39.515l-5.285 
                            1.573h-18.636l-5.592-1.573l-2.179-39.515l-1.861-58.343v-47.051l1.861-49.244l1.712-30.273l3.884-1.721zm-187.538
                            0l3.726 1.883l1.865 30.11l1.865 48.928v47.055l-1.865 58.656l-.307 39.515l-5.284 
                            1.573h-18.638l-5.594-1.573l-2.172-39.515l-1.86-58.343v-47.051l1.86-49.244l1.712-30.273l3.88-1.721zm102.698 0l3.726 
                            1.883l1.865 30.11l1.865 48.928v47.055l-1.865 58.656l-.307 39.515l-5.284 
                            1.573h-18.638l-5.59-1.573l-2.176-39.515l-1.861-58.343v-47.051l1.861-49.244l1.712-30.273l3.883-1.721zm96.758-40.186v31.255H67.721v-31.255ZM220.785 
                            64l163.96 37.546l-6.574 11.57H64.15l-9.823-9.383z" /></g>
                        </svg>
                        <h3> Empresa</h3>
                    </a>

                    <a href="/perfil" class="nav-option option5">
                        <svg width="36px" height="36px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="M16 7.992C16 3.58 12.416 0 8 0S0 3.58 0 7.992c0 
                            2.43 1.104 4.62 2.832 6.09c.016.016.032.016.032.032c.144.112.288.224.448.336c.08.048.144.111.224.175A7.98 
                            7.98 0 0 0 8.016 16a7.98 7.98 0 0 0 4.48-1.375c.08-.048.144-.111.224-.16c.144-.111.304-.223.448-.335c.016-.016.032-.016.032-.032c1.696-1.487 
                            2.8-3.676 2.8-6.106zm-8 7.001c-1.504 0-2.88-.48-4.016-1.279c.016-.128.048-.255.08-.383a4.17 
                            4.17 0 0 1 .416-.991c.176-.304.384-.576.64-.816c.24-.24.528-.463.816-.639c.304-.176.624-.304.976-.4A4.15 
                            4.15 0 0 1 8 10.342a4.185 4.185 0 0 1 2.928 1.166c.368.368.656.8.864 1.295c.112.288.192.592.24.911A7.03 
                            7.03 0 0 1 8 14.993zm-2.448-7.4a2.49 2.49 0 0 1-.208-1.024c0-.351.064-.703.208-1.023c.144-.32.336-.607.576-.847c.24-.24.528-.431.848-.575c.32-.144.672-.208 1.024-.208c.368 
                            0 .704.064 1.024.208c.32.144.608.336.848.575c.24.24.432.528.576.847c.144.32.208.672.208 1.023c0 .368-.064.704-.208 1.023a2.84 2.84 
                            0 0 1-.576.848a2.84 2.84 0 0 1-.848.575a2.715 2.715 0 0 1-2.064 0a2.84 2.84 0 0 1-.848-.575a2.526 2.526 0 0 1-.56-.848zm7.424 5.306c0-.032-.016-.048-.016-.08a5.22 
                            5.22 0 0 0-.688-1.406a4.883 4.883 0 0 0-1.088-1.135a5.207 5.207 0 0 0-1.04-.608a2.82 2.82 0 0 0 .464-.383a4.2 4.2 0 0 0 .624-.784a3.624 3.624 0 0 0 
                            .528-1.934a3.71 3.71 0 0 0-.288-1.47a3.799 3.799 0 0 0-.816-1.199a3.845 3.845 0 0 0-1.2-.8a3.72 3.72 0 0 0-1.472-.287a3.72 3.72 0 0 0-1.472.288a3.631 3.631 0 
                            0 0-1.2.815a3.84 3.84 0 0 0-.8 1.199a3.71 3.71 0 0 0-.288 1.47c0 .352.048.688.144 1.007c.096.336.224.64.4.927c.16.288.384.544.624.784c.144.144.304.271.48.383a5.12 5.12 0
                            0 0-1.04.624c-.416.32-.784.703-1.088 1.119a4.999 4.999 0 0 0-.688 1.406c-.016.032-.016.064-.016.08C1.776 11.636.992 9.91.992 7.992C.992 4.14 4.144.991 8 .991s7.008 
                            3.149 7.008 7.001a6.96 6.96 0 0 1-2.032 4.907z" />
                            </g>
                        </svg>
                        <h3> Perfil</h3>
                    </a>

                    <a href="/logout" class="nav-option logout">
                        <svg width="36px" height="36px" viewBox="0 0 36 36" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="M7 6h16v9.8h2V6a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v24a2 2 
                        0 0 0 2 2h16a2 2 0 0 0 2-2H7Z" class="clr-i-outline clr-i-outline-path-1" />
                                <path fill="currentColor" d="M28.16 17.28a1 1 0 0 0-1.41 1.41L30.13 22h-14.5a1 1 0 0 0-1 
                        1a1 1 0 0 0 1 1h14.5l-3.38 3.46a1 1 0 1 0 1.41 1.41l5.84-5.8Z" class="clr-i-outline 
                        clr-i-outline-path-2" />
                                <path fill="none" d="M0 0h36v36H0z" />
                            </g>
                        </svg>
                        <h3>Cerrar sesión</h3>
                    </a>

                </div>
            </nav>
        </div>
  </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
</body>

</html>

<?php
//  } else {
    //  header('Location: ../../index.php');
    //  exit();
//  }
?>