<?php
include('header-index.php');

if(isset($_SESSION['username'])) {
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
        print_r($carrito);
?>

<div>
<h2>Carrito</h2><b><?php foreach ($carrito as $prod) {
    echo '<p>'. $prod .'</p>';
} ?></b>

</div>
<?php
    }
} else {
?>
<div class="heading-carrito">
    <h2>Carrito</h2><b>(0 artículos)</b>
</div>

<section class="iniciar-carrito">
    <h2>Inicia sesión para ver tus artículos</h2>
    <a href="/cuenta">Iniciar sesión</a>
</section>
<?php
}
?>
<?php
include('footer.php');
