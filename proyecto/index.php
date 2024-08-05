<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youCommerce</title>
</head>
<body>
    <header class="header-commerce">
    <a href="" id="cart-responsive" class="message">
            <div class="circle"></div>
                <svg width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128" 
            role="img" xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor"><path fill="currentColor" fill-rule="evenodd" 
                d="M19.148 5.25H5.335l-1.18-2.115A.75.75 0 0 0 3.5 2.75H2a.75.75 0 0 0 
                0 1.5h1.06l1.164 2.088L6.91 12.28l.003.006l.237.523l-2.697 2.877a.75.75 0 0 0
                 .462 1.258l2.458.281a40.68 40.68 0 0 0 9.254 0l2.458-.28a.75.75 0 0 
                 0-.17-1.491l-2.458.28a39.256 39.256 0 0 1-8.914 0l-.975-.11l1.98-2.112a.768.768 0 
                 0 0 .053-.064l.752.098c1.055.138 2.122.165 3.182.08a9.29 9.29 0 0 0 
                 6.366-3.268l.579-.685a.734.734 0 0 0 .053-.072l1.078-1.642c.764-1.164-.071-2.71-1.463-2.71ZM8.656 11.944a.484.484 0 0 1-.377-.278l-.002-.003l-2.22-4.913h13.09a.25.25 0 0 1 .21.387l-1.053 1.604l-.549.65a7.79 7.79 0 0 1-5.338 2.741c-.957.076-1.919.052-2.87-.072l-.89-.116Z" clip-rule="evenodd"/><path fill="currentColor" d="M6.5 18.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3ZM16 20a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0Z"/></g>
            </svg>
            </a>
        <nav class="nav">
            <h1 class="logo">youCommerce</h1>
            <div class="searchbar">
            <form class="form-for" action="" method="get">
                <label for="busqueda"></label>
                <input type="text" id="busqueda" name="buscar" placeholder="Encontrá todo lo que buscas">
                <button class="searchbtn" type="submit">
                <svg width="36px" height="36px" viewBox="0 0 48 48" fill="currentColor" 
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                 d="m42.501 42.5l-7.351-7.776a17.244 17.244 0 1 0-7.075 4.422"/></g>
            </svg>
            </button>
            </form>
            </div>
        </nav>
        

        <ul class="ul-for-nav">
            <a href="./vista/register.php">
            <li>Regístrate</li>
            </a>
            <a href="./vista/account.php">
            <li>Mi cuenta</li>
            </a>
            <a href="" class="message">
            <div class="circle"></div>
                <svg width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128" 
            role="img" xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor"><path fill="currentColor" fill-rule="evenodd" 
                d="M19.148 5.25H5.335l-1.18-2.115A.75.75 0 0 0 3.5 2.75H2a.75.75 0 0 0 
                0 1.5h1.06l1.164 2.088L6.91 12.28l.003.006l.237.523l-2.697 2.877a.75.75 0 0 0
                 .462 1.258l2.458.281a40.68 40.68 0 0 0 9.254 0l2.458-.28a.75.75 0 0 
                 0-.17-1.491l-2.458.28a39.256 39.256 0 0 1-8.914 0l-.975-.11l1.98-2.112a.768.768 0 
                 0 0 .053-.064l.752.098c1.055.138 2.122.165 3.182.08a9.29 9.29 0 0 0 
                 6.366-3.268l.579-.685a.734.734 0 0 0 .053-.072l1.078-1.642c.764-1.164-.071-2.71-1.463-2.71ZM8.656 11.944a.484.484 0 0 1-.377-.278l-.002-.003l-2.22-4.913h13.09a.25.25 0 0 1 .21.387l-1.053 1.604l-.549.65a7.79 7.79 0 0 1-5.338 2.741c-.957.076-1.919.052-2.87-.072l-.89-.116Z" clip-rule="evenodd"/><path fill="currentColor" d="M6.5 18.5a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3ZM16 20a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0Z"/></g>
            </svg>
            </a>
        </ul>
        <div onclick="menuResponsive()" id="menu-responsive" class="responsive-menu">
        <svg width="48px" height="48px" 
        viewBox="0 0 32 32" fill="currentColor" x="217" y="217" role="img"
         xmlns="http://www.w3.org/2000/svg">
         <g fill="currentColor"><path fill="none" 
         stroke="currentColor" stroke-linecap="round" 
         stroke-linejoin="round" stroke-width="2" 
         d="M4 8h24M4 16h24M4 24h24"/></g>
    </svg>
        </div>
    </header>

    <ul id="options-responsive" class="responsive-menu-list visible">
        <div class="business-logo">
        <svg 
        width="40px" height="40px" viewBox="0 0 48 48" fill="currentColor" 
        x="226" y="226" role="img" xmlns="http://www.w3.org/2000/svg">
        <g fill="currentColor"><circle cx="13.856" cy="37.551" r="3.051" 
        fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        <circle cx="31.755" cy="37.551" r="3.051" fill="none" stroke="currentColor" 
        stroke-linecap="round" stroke-linejoin="round"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.805h4.678L13.856 34.5h17.899"/><circle cx="37.5" cy="16.703" r="6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M41.161 9.28L40.1 11.299m-7.583-2.375l4.017-1.526m.966 9.305l-1.271-3.661m-26.155 2.302l18.07.902M13.031 30.323h20.91c3.254 0 3.56-4.416 3.56-4.416m-26.345-5.084l18.005.508m-17.098 4.09l23.075.441m-4.604 4.461l.966-6.603m-6.763 6.603l-.153-14.255m-6.965-.347l1.49 14.602"/></g>
        </svg>

        <h2 class="logo">youCommerce</h2>
        </div>
        <div class="menu-normal">
        <a href="" class="menu-normal-actions active">
        <svg 
        width="28px" height="28px" viewBox="0 0 16 16" 
        fill="currentColor" x="128" y="128" role="img" 
        xmlns="http://www.w3.org/2000/svg">
        <g fill="currentColor"><path fill="currentColor" 
        fill-rule="evenodd" d="m8.36 1.37l6.36 5.8l-.71.71L13 6.964v6.526l-.5.5h-3l-.5-.5v-3.5H7v3.5l-.5.5h-3l-.5-.5V6.972L2 7.88l-.71-.71l6.35-5.8h.72zM4 6.063v6.927h2v-3.5l.5-.5h3l.5.5v3.5h2V6.057L8 2.43L4 6.063z" clip-rule="evenodd"/></g>
        </svg>   
        Inicio</a>
        <a class="menu-normal-actions" href="">
            <svg width="28px" height="28px" viewBox="0 0 32 32" 
            fill="currentColor" x="217" y="217" role="img" 
            xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor"><path fill="none" 
            stroke="currentColor" stroke-linecap="round" 
            stroke-linejoin="round" stroke-width="2" 
            d="M22 11c0 5-3 9-6 9s-6-4-6-9s2-8 6-8s6 3 6 8ZM4 30h24c0-9-6-10-12-10S4 21 4 30Z"/></g>
            </svg>
        Mi cuenta</a>

        <a class="menu-normal-actions" href="">Regístrate</a>
        <a class="menu-normal-actions" href="">
            <svg width="28px" height="28px" viewBox="0 0 32 32" fill="currentColor" x="217" y="217" role="img" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="currentColor" d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2Zm0 26a12 12 0 1 1 12-12a12 12 0 0 1-12 12Z"/><circle cx="16" cy="23.5" r="1.5" fill="currentColor"/><path fill="currentColor" d="M17 8h-1.5a4.49 4.49 0 0 0-4.5 4.5v.5h2v-.5a2.5 2.5 0 0 1 2.5-2.5H17a2.5 2.5 0 0 1 0 5h-2v4.5h2V17a4.5 4.5 0 0 0 0-9Z"/></g>
            </svg>
            Ayuda</a>
        </div>
        <a class="opinions" href="">
        <svg width="28px" height="28px" viewBox="0 0 32 32" 
        fill="currentColor" x="217" y="217" role="img"
        xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 4h28v18H16l-8 7v-7H2Z"/></g>
        </svg>
        Dejanos tu opinión</a>
        <svg onclick="isMenuVisible()" class="close-icon" id="close-ico" width="28px" height="28px" 
            viewBox="0 0 16 16" fill="currentColor" 
            x="128" y="128" role="img"
            xmlns="http://www.w3.org/2000/svg">
            <g fill="currentColor">
            <path fill="currentColor" 
            fill-rule="evenodd" 
            d="m8 8.707l3.646 3.647l.708-.707L8.707 8l3.647-3.646l-.707-.708L8 7.293L4.354 3.646l-.707.708L7.293 8l-3.646 3.646l.707.708L8 8.707z" clip-rule="evenodd"/></g>
    </svg>
    </ul>
    <main class="main-products" id="product-container">

    </main>
    <section class="pay-methods">
        <h3>Métodos de pago</h3>
        <div class="pay-options">
            <img src="./assets/imgs/mastercard.png" alt="">
            <img src="./assets/imgs/mercado.png" alt="">
            <img src="./assets/imgs/paypal.png" alt="">
            <img src="./assets/imgs/visa.png" alt="">
        </div>
    </section>
    <footer class="footer-commerce">
        <ul class="ul-footer-one">
            <h2>Información ùtil</h2>
            <a href="">
            <li>Términos y condiciones</li>
            </a>
            <a href="">
            <li>Políticas de devolución de productos</li>
            </a>
            <a href="">
            <li>Medios de pago</li>
            </a>
        </ul>
        <ul class="ul-footer-two">
            <h2>Preguntas frecuentes</h2>
            <a href="">
            <li>Envíos</li>
            </a>
            <a href="">
            <li>Sustentabilidad</li>
            </a>
            <a href="">
                <li>Compra protegida</li>
            </a>
        </ul>
    </footer>
    <div class="div-for-small">

    <small class="tienda-copy"> &copy;<span>youCommerce 2024</span> </small>
    </div>
    <script src="main.js"></script>
</body>
</html>