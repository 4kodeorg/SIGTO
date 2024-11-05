<?php
include('header-index.php');
?>

<div class='product-details row'>
    <div class="col">
        <div class="row img-active-product">
            <img src="../imagenes/productos/polocam.jpeg" alt="">

        </div>
        <div class="row below-img">
            <img src="../imagenes/productos/polocamisa.jpeg" alt="">
            <img src="../imagenes/productos/67242aa8dae68_Screenshot 2024-10-28 at 12.03.21 PM.png" alt="">
            <img src="../imagenes/productos/672552077f45c_Screenshot 2024-10-29 at 2.20.40 PM.png" alt="">
            <img src="../imagenes/productos/67257400307b9_Screenshot 2024-10-28 at 12.03.42 PM.png" alt="">
        </div>
    </div>
    <div class="col product-content">
        <h2 class="fs-1"> <?php echo htmlspecialchars($product['nombre']) ?> </h2>
       <section>
       <p><strong>Descripción:</strong> <?php echo  htmlspecialchars($product['descripcion']) ?></p>
        <p><strong>Precio:</strong> $ <?php echo htmlspecialchars($product['precio']) ?></p>
        <p><strong>Stock de unidades:</strong> <?php echo htmlspecialchars($product['stock']) ?></p>

       </section>
        <form method='POST' id="form-cart-item-<?php echo $product['sku']?>" action='?action=add_to_cart'>
            <label for='quantity'>Cantidad: </label>
            <input class='product-quant' type='number' name='quantity' value=1>
            <input type='hidden' name='id_product' value=' <?php echo $product['sku'] ?>'>
            <input type='hidden' name='id_user' value=' <?php echo $idComprador ?>'>
            <input type='hidden' name='titulo' value='<?php echo $product['nombre']?>'>
            <input type='hidden' name='price' value='<?php echo $product['precio'] ?>'>
            <input type='hidden'  name="id_vendedor" value='<?php echo $product['id_usu_ven'] ?>'>
            <div class="row">
            <button class='cart-btn'
            type='button' data-id="<?php echo $product['sku'] ?>" onclick="addToCart(this, event)" name='submit'>
            <svg class='cart' fill='currentColor' viewBox='0 0 576 512' height='20px' width='20px' xmlns='http://www.w3.org/2000/svg'><path d='M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z'></path></svg>
                    <svg xmlns='http://www.w3.org/2000/svg' height='20px' width='20px' viewBox='0 0 640 512' class='product'><path d='M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0h12.6c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7V448c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V197.7l-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0h12.6z'>
                    </path></svg>
                </button>
            <button class="checkout-btn-prod" data-user-id="<?php echo $idComprador ?>" data-id="<?php echo $product['sku'] ?>" 
            onclick="shopNow(this, event)" name="submit">Finalizar compra
            <svg xmlns="http://www.w3.org/2000/svg" width="13px" height="13px" viewBox="0 0 24 24">
                <path fill="currentColor" fill-rule="evenodd" d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18m-.232-5.36l5-6l-1.536-1.28l-4.3 5.159l-2.225-2.226l-1.414 1.414l3 3l.774.774z" clip-rule="evenodd"/></svg>
            </button>
            </div>
        </form>
        <div class="row medios-de-pago-row">
            <h3 class="text-center">Medios de pago</h3>
            <div class="medios-de-pago-cont">
            <img src="../assets/imgs/mastercard.png" alt="">
            <img src="../assets/imgs/paypal.png" alt="">
            <img src="../assets/imgs/visa.png" alt="">
            <img src="../assets/imgs/abitab.png" alt="">

            </div>
        </div>
    </div>

</div>

<div class="container-related-prods">
    <?php if (isset($data['related_products']) && count($data['related_products']) > 0) {
        foreach ($data['related_products'] as $prod) {
            if ($prod['sku'] != $product['sku']) {
                echo '<div class="product-details">
                <p><strong>'.$prod['nombre']. '</strong></p> 
                                <p><strong>'.$prod['descripcion'] .' </strong></p>
                                <p><strong>'. $prod['precio'] .'</strong></p>
                <form method="POST" id="form-cart-item-'.$prod['sku'].'" action="?action=add_to_cart">
                <label for="quantity">Cantidad</label>
                <input class="product-quant" type="number" id="quantity" name="quantity" value=1>
                <input type="hidden" name="id_product" value="'.$prod['sku'].'">
                <input type="hidden" name="id_user" value="'.$idComprador.'">
                <input type="hidden" name="titulo" value="'.$prod['nombre'].'">
                <input type="hidden" name="price" value="'.$prod['precio'].'">
                <input type="hidden" name="id_vendedor" value="'.$prod['id_usu_ven'].'">
                <button class="cart-btn" data-id="'.$prod['sku'].'" name="submit" onclick="addToCart(this, event)">
                <svg class="cart" fill="currentColor" viewBox="0 0 576 512" height="25px" width="25px" xmlns="http://www.w3.org/2000/svg"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path></svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" width="20px" viewBox="0 0 640 512" class="product"><path d="M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0h12.6c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7V448c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V197.7l-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0h12.6z">
                </path></svg></button>
                </form>
                </div>';

            }
        }
    }
    ?>
</div>
<div id='container-modal-login' class='modal-home-login'> </div>
<div id="success-carrito-message" class="container-ok-message">
    <p></p>
    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 48 48">
        <linearGradient id="I9GV0SozQFknxHSR6DCx5a_70yRC8npwT3d_gr1" x1="9.858" x2="38.142" y1="9.858" y2="38.142" gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#21ad64"></stop>
            <stop offset="1" stop-color="#088242"></stop>
        </linearGradient>
        <path fill="url(#I9GV0SozQFknxHSR6DCx5a_70yRC8npwT3d_gr1)" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path>
        <path d="M32.172,16.172L22,26.344l-5.172-5.172c-0.781-0.781-2.047-0.781-2.828,0l-1.414,1.414	c-0.781,0.781-0.781,2.047,0,2.828l8,8c0.781,0.781,2.047,0.781,2.828,0l13-13c0.781-0.781,0.781-2.047,0-2.828L35,16.172	C34.219,15.391,32.953,15.391,32.172,16.172z" opacity=".05"></path>
        <path d="M20.939,33.061l-8-8c-0.586-0.586-0.586-1.536,0-2.121l1.414-1.414c0.586-0.586,1.536-0.586,2.121,0	L22,27.051l10.525-10.525c0.586-0.586,1.536-0.586,2.121,0l1.414,1.414c0.586,0.586,0.586,1.536,0,2.121l-13,13	C22.475,33.646,21.525,33.646,20.939,33.061z" opacity=".07"></path>
        <path fill="#fff" d="M21.293,32.707l-8-8c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0	L22,27.758l10.879-10.879c0.391-0.391,1.024-0.391,1.414,0l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414l-13,13	C22.317,33.098,21.683,33.098,21.293,32.707z"></path>
    </svg>
</div>

<?php
include('footer.php');
