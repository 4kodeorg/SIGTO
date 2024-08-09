<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = testData($_POST['titulo']);
    $descr = testData($_POST['descripcion']);
    $estado = testData($_POST['estado']);
    $precio = testData($_POST['precio']);

}

function testData($datos) {
    $data = trim($datos);
    $data = stripslashes($datos);
    $data = htmlspecialchars($datos);
    return $data;

}

?>