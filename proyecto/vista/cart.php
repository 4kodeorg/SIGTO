<?php
include('header-index.php');

if(isset($_SESSION['username'])) {
    
?>

<div>
<h2>Carrito</h2><b><?php ?></b>


</div>
<?php

} else {
?>
<div class="heading-carrito">
    <h2>Carrito</h2><b>()</b>
</div>

<section class="iniciar-carrito">
    <h2>Inicia sesión para ver tus artículos</h2>
    <a href="">Iniciar sesión</a>
</section>
<?php
}
?>
<?php
include('footer.php')
?>