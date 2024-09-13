<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = testData($_POST['titulo']);
    $descr = testData($_POST['descripcion']);
    $origen = testData($_POST['origen']);
    $cantidad = testData($_POST['cantidad']);
    $precio = testData($_POST['precio']);

}
function testData($datos) {
    $data = trim($datos);
    $data = stripslashes($datos);
    $data = htmlspecialchars($datos);
    return $data;
}
function generateId() {
    $id = rand(1, 100);
    return $id;
}
function genNum() {
    $numVis = rand(100, 1000);
    return $numVis;
}
function getComms() {
    $numCom = rand(20, 100);
    return $numCom;
}

$productos = [
[
    "id" => 73,
    "titulo" => "Heladera LG",
    "descripcion" => "Heladera Inverter Frio Seco 300L",
    "visitas" => 850,
    "comentarios" => 35,
    "precio" => 8500
],
[
    "id" => 83,
    "titulo" => "Celular Samsung",
    "descripcion" => "Celular Samsung S23 80MP AI Cámara",
    "visitas" => 1220,
    "comentarios" => 42,
    "precio" => 38000
],
[
    "id" => 21,
    "titulo" => "Bicicleta Trekk",
    "descripcion" => "Bicicleta de montaña 18 velocidades rodado 29",
    "visitas" => 350,
    "comentarios" => 55,
    "precio" => 25000
],
[
    "id" => 17,
    "titulo" => "Lavarropas beko",
    "descripcion" => "Lavarropas 11 kg Aquamotion sense",
    "visitas" => 720,
    "comentarios" => 15,
    "precio" => 14000
],
[
    "id" => 97,
    "titulo" => "Lavarropas LG",
    "descripcion" => "Lavarropas 25 kg Aquamotion sense",
    "visitas" => 470,
    "comentarios" => 35,
    "precio" => 14000
]
];


?>