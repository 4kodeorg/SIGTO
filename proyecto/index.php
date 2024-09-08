<?php
include('./config/config.php');

$request = trim($_SERVER['REQUEST_URI'], '/');
$request = strtok($request, '?');

function renderPage($page) {
    $file = __DIR__ . "/vista/{$page}.php";
    if(file_exists($file)) {
        include ($file);
    } else {
        http_response_code(404);
        echo "404 - Page not found";
    }
}
function renderBackOffice($page) {
    $file = __DIR__ ."/vista/administracion/{$page}.php";
    if ( file_exists($file) ) {
        include($file);
    }
    else {
        http_response_code(404);
        echo "404 - Page not found";
    }
}

switch ($request) {
    case 'registro':
        renderPage('register');
        break;
    case 'product':
        renderPage('product');
        break;
    case 'cuenta':
        renderPage('account');
        break;
    case 'carrito':
        renderPage('cart');
        break;
    case 'admin':
        header('Location: /admin/main');
        break;
    case 'admin/main':
        renderBackOffice('general');
        break;
    case 'admin/estadisticas':
        renderBackOffice('estadisticas');
        break;
    case 'admin/empresa':
        renderBackOffice('company');
        break;
    case 'admin/productos':
        renderBackOffice('productos');
        break;
    case 'admin/perfil':
        renderBackOffice('profile');
        break;
    case 'logout':
        header('Location: /cuenta');
        break;
    case '':
    case '/':
        renderPage('home');
        break;
    default:
        renderPage('error');
        break;
}
