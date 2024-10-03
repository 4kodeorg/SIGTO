<?php
include('header-index.php');
?>

<div class='product-details'>
    <h2> <?php echo htmlspecialchars($product['titulo']) ?> </h2>
    <p><strong>Descripción:</strong> <?php echo  htmlspecialchars($product['descripcion']) ?></p>
    <p><strong>Precio:</strong> <?php echo htmlspecialchars($product['precio']) ?></p>
    <p><strong>Cantidad Disponible:</strong> <?php echo htmlspecialchars($product['cantidad']) ?></p>
    <form method='POST' action='?action=add_to_cart'>
        <label for='quantity'>Cantidad: </label>
        <input class='product-quant' type='number' name='quantity' value=1>
        <input type='hidden' name='id_product' value=' <?php echo $product['id'] ?>'>
        <input type='hidden' name='id_user' value=' <?php echo $_SESSION['id']  ?>'>
        <button type='submit' name='submit'>Agregar al carrito</button>
    </form>
</div>



<?php
include('footer.php');
