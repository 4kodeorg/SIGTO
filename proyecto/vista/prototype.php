<div class='container-prods' id='result-container'>

</div>
<section>
    <?php

    if (isset($data['message']) && !empty($data['message'])) {
        echo '<h2>' . $data['message'] . '</h2>';
    } elseif (isset($data['resultados']) && is_array($data['resultados']) && !empty($data['resultados'])) {

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
        foreach ($data['resultados'] as $product) {
            echo '
                      <tr>
                    <a href="/product/' . $product['id'] . '">' . $product['titulo'] . '
                                        <th>' . $product['titulo'] . '</th>
                                        <td>' . $product['descripcion'] . '</td>
                                        <td>' . $product['precio'] . '</td>
                                        <td><form id="form-cart-item" method="POST" action="?action=add_to_cart"> 
                                            <input class="product-quant" type="number" name="quantity" value=1>
                                            <input type="hidden" name="id_product" value=' . $product['id'] . '>
                                            <input type="hidden" name="id_user" value=' . $usId . '>
                                            <input type="hidden" name="price" value=' . $product['precio'] . '>
                                            <button class="add-to-cart-btn" type="submit" name="submit">
                                            
                                            </button>
                                        </form></td>
                                    </tr> </a>
                                    </tbody>';
        }
    } else {

        if (isset($data['productos']) && !empty($data['productos'])) {

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

            foreach ($data['productos'] as $product) {
                foreach ($data['favoritos'] as $fav) {
                    if ($fav['id_prod'] === $product['id']) {
                        echo '   
                        <a href="/product/' . $product['id'] . '"><tr>
                        <th>' . $product['titulo'] . '</th>
                        <td>' . $product['descripcion'] . '</td>
                        <td>' . $product['precio'] . '</td>
                        <td><form id="form-cart-item-<?php echo '.$product["id"].'; ?>" method="POST" action="?action=add_to_cart"> 
                        <input class="product-quant" type="number" name="quantity" value=1>
                        <input type="hidden" name="id_product" value="' . $product['id'] . '">
                        <input type="hidden" name="id_user" value="' . $usId . '">
                        <input type="hidden" name="price" value="' . $product['precio'] . '">
                        <button name="submit" type="button" data-id="<?php echo '.$product["id"].'; ?>" onclick="goToCart(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                        width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.5 10h4m-2-2v4m4 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m-8 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M3.71 5.4h15.214c1.378 0 2.373 1.27 1.995 2.548l-1.654 5.6C19.01 14.408 18.196 15 17.27 15H8.112c-.927 0-1.742-.593-1.996-1.452zm0 0L3 3"/></svg> 
                        </button>
                    </form>
                    <!--  <button class="add-to-cart-btn" data-product-price="' . $product['precio'] . '" onclick="setToCart(event, this)" name="submit">
                        agregar </button> -->
                    <button class="add-to-fav-btn favoritos" onclick="updateFavorites(event, this)" data-product-id="' . $product['id'] . '" data-user-id="' . $usId . '">
                     <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79"/>
                     </svg> 
                     </button></td>
                </tr> </a>
                </tbody>';
                    } else {
                        echo '   
                        <a href="/product/' . $product['id'] . '"><tr>
                        <th>' . $product['titulo'] . '</th>
                        <td>' . $product['descripcion'] . '</td>
                        <td>' . $product['precio'] . '</td>
                        <td><form id="form-cart-item-<?php echo '.$product["id"].'; ?>" method="POST" action="?action=add_to_cart"> 
                        <input class="product-quant" type="number" name="quantity" value=1>
                        <input type="hidden" name="id_product" value=' . $product['id'] . '>
                        <input type="hidden" name="id_user" value=' . $usId . '>
                        <input type="hidden" name="price" value=' . $product['precio'] . '>
                        <button name="submit" type="button" data-id="<?php echo '.$product["id"].'; ?>" onclick="goToCart(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                        width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.5 10h4m-2-2v4m4 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m-8 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M3.71 5.4h15.214c1.378 0 2.373 1.27 1.995 2.548l-1.654 5.6C19.01 14.408 18.196 15 17.27 15H8.112c-.927 0-1.742-.593-1.996-1.452zm0 0L3 3"/></svg> 
                        </button>
                    </form>
                        <!-- <button class="add-to-cart-btn" data-product-price="' . $product['precio'] . '" data-product-id="' . $product['id'] . '" onclick="setToCart(event, this)" name="submit">agregar</button> -->
                    <button class="add-to-fav-btn" onclick="updateFavorites(event, this)" data-product-id="' . $product['id'] . '" data-user-id="' . $usId . '">
                     <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79"/></svg> 
                     </button></td>
                </tr> </a>
                </tbody>';
                    }
                }
            }
        } else {
            echo "<tr><td colspan='4'> No hay productos disponibles </td></tr>";
        }
    }
    ?>

    </table>
</section>
