<?php

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

function renderPage($page) {
    $file = __DIR__ . "/vista/{$page}.php";
    var_dump($file);
    if(file_exists($file)) {
        include ($file);
    } else {
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
    case '':
    case '/':
        renderPage('home');
        break;
    default:
        renderPage('home');
        break;
}
