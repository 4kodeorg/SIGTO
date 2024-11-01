<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = strtok($_SERVER['REQUEST_URI'], '?');

$action = $_GET['action'] ?? null;


require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Router.php';

$router = new Router($request, $action);
$router->route();
