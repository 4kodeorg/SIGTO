<?php

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

function renderPage($page) {
    include __DIR__ . "/{$page}.php";
}

switch ($request) {
    case '/vista/register':
        renderPage('register');
        break;
    case '/vista/product':
        renderPage('product');
        break;
    default:
        renderPage('home');
        break;
}