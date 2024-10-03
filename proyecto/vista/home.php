<?php
include('header-index.php');
include('hero.php');
?>
<div class='container-prods' id='result-container'>

</div>
<section>
    <?php
    $userId = 0;
    if (isset($data['message']) && !empty($data['message'])) {
        echo '<h2>' . $data['message'] . '</h2>';
    } elseif (isset($data) && is_array($data) && !empty($data)) {
        echo '<table class="table px-4 my-5">
        <thead>
            <tr>
                <th colspan="5">
                    <div class="report-header">
                        <h2 class="mx-auto pt-5">Resultados de busqueda</h2>
                    </div>
                    <hr>
                </th>
            </tr>
            <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>
        <tbody class="mx-auto">';
        foreach ($data as $product) {
            echo '
                      <tr>
                    <a href="/product/' . $product['id'] . '">' . $product['titulo'] . '
                                        <th>' . $product['titulo'] . '</th>
                                        <td>' . $product['descripcion'] . '</td>
                                        <td>' . $product['precio'] . '</td>
                                        <td><form method="POST" action="?action=add_to_cart"> 
                                            <input class="product-quant" type="number" name="quantity" value=1>
                                            <input type="hidden" name="id_product" value=' . $product['id'] . '>
                                            <input type="hidden" name="id_user" value=' . $userId . '>
                                            <button class="add-to-cart-btn" type="submit" name="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                            width="28px" height="28px" viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.5 10h4m-2-2v4m4 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m-8 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M3.71 5.4h15.214c1.378 0 2.373 1.27 1.995 2.548l-1.654 5.6C19.01 14.408 18.196 15 17.27 15H8.112c-.927 0-1.742-.593-1.996-1.452zm0 0L3 3"/></svg> 
                                            </button>
                                        </form></td>
                                    </tr> </a>
                                    </tbody>';
        }
    } else {
        $userId = $_SESSION['id'] ?? 0;
        require_once $_SERVER['DOCUMENT_ROOT'] . '/controlador/ProductController.php';
        $productController = new ProductController();

        $productItems = $productController->getProductsByLimit();
        if (!empty($productItems)) {
            echo '<table class="table px-4 my-5">
        <thead>
            <tr>
                <th colspan="5">
                    <div class="report-header">
                        <h2 class="mx-auto pt-5">Articulos publicados</h2>
                    </div>
                    <hr>
                </th>
            </tr>
            <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>
        <tbody class="mx-auto">';
            foreach ($productItems as $product) {
                echo '
                          
                        <a href="/product/' . $product['id'] . '"><tr>
                    <th>' . $product['titulo'] . '</th>
                    <td>' . $product['descripcion'] . '</td>
                    <td>' . $product['precio'] . '</td>
                    <td><form method="POST" action="?action=add_to_cart"> 
                        <input class="product-quant" type="number" name="quantity" value=1>
                        <input type="hidden" name="id_product" value=' . $product['id'] . '>
                        <input type="hidden" name="id_user" value=' . $userId . '>
                        <button class="add-to-cart-btn" type="submit" name="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                        width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.5 10h4m-2-2v4m4 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m-8 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M3.71 5.4h15.214c1.378 0 2.373 1.27 1.995 2.548l-1.654 5.6C19.01 14.408 18.196 15 17.27 15H8.112c-.927 0-1.742-.593-1.996-1.452zm0 0L3 3"/></svg> 
                        </button>
                    </form></td>
                </tr> </a>
                </tbody>';
            }
        } else {
            echo "<tr><td colspan='4'> No hay productos disponibles </td></tr>";
        }
    }
    ?>

    </table>
</section>
<section class="pay-methods">
    <h3>Métodos de pago</h3>
    <div class="pay-options">
        <img src="../assets/imgs/mastercard.png" alt="">
        <img src="../assets/imgs/mercado.png" alt="">
        <img src="../assets/imgs/paypal.png" alt="">
        <img src="../assets/imgs/visa.png" alt="">
        <img src="../assets/imgs/abitab.png" alt="">
        <img src="../assets/imgs/redpagos.png" alt="">
        <img src="../assets/imgs/mastercard.png" alt="">
        <img src="../assets/imgs/mercado.png" alt="">
        <img src="../assets/imgs/paypal.png" alt="">
        <img src="../assets/imgs/visa.png" alt="">
        <img src="../assets/imgs/abitab.png" alt="">
        <img src="../assets/imgs/redpagos.png" alt="">
    </div>
</section>
<div class="container-message-support">
    <figure class="figure-chat-support">
        <img src="../assets/imgs/chatbubble.svg" alt="">
        <figcaption>Estamos aquì para ayudarte!</figcaption>
    </figure>
</div>

<?php
include('footer.php');
