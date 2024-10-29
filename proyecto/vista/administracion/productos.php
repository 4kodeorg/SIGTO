<?php
require('headerback.php')
?>

<div class="main-container">

    <div class="main">

        <div class="box-container">

            <div class="box box1">
                <div class="text">
                    <h2 class="topic-heading">60.5k</h2>
                    <h2 class="topic">Visitas</h2>
                </div>
                <svg width="56px" height="56px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <path fill="currentColor" d="M8 6.003a2.667 2.667 0 1 1 
                    0 5.334a2.667 2.667 0 0 1 0-5.334Zm0 1a1.667 1.667 0 1 0 0 3.334a1.667 1.667 0 
                    0 0 0-3.334Zm0-3.336c3.076 0 5.73 2.1 6.467 5.043a.5.5 0 1 1-.97.242a5.67 5.67 
                    0 0 0-10.995.004a.5.5 0 0 1-.97-.243A6.669 6.669 0 0 1 8 3.667Z" />
                    </g>
                </svg>
            </div>

            <div class="box box2">
                <div class="text">
                    <h2 class="topic-heading">150</h2>
                    <h2 class="topic">En favoritos</h2>
                </div>

                <svg width="56px" height="56px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <path fill="currentColor" d="M10.54 2c.289.001.57.088.81.25a1.38
                    1.38 0 0 1 .45 1.69l-.97 2.17h2.79a1.36 1.36 0 0 1 1.16.61a1.35 1.35 0 0 1 
                    .09 1.32c-.67 1.45-1.87 4.07-2.27 5.17a1.38 1.38 0 0 1-1.29.9H2.38A1.4 1.4 
                    0 0 1 1 12.71V9.2a1.38 1.38 0 0 1 1.38-1.38h1.38L9.6 2.36a1.41 1.41 0 0 1 
                    .94-.36zm.77 11.11a.39.39 0 0 0 .36-.25c.4-1.09 1.47-3.45 2.33-5.24a.39.39 0 
                    0 0 0-.36a.37.37 0 0 0-.38-.15h-3.3l-.52-.68v-.46l1.09-2.44a.37.37 0 0 
                    0-.13-.46a.38.38 0 0 0-.48 0L4.22 8.66l-.47.13H2.38A.38.38 0 0 0 2 9.2v3.51a.4.4
                    0 0 0 .38.4h8.93z" />
                    </g>
                </svg>
            </div>

            <div class="box box3">
                <div class="text">
                    <h2 class="topic-heading">320</h2>
                    <h2 class="topic">Comentarios</h2>
                </div>
                <svg width="56px" height="56px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <path fill="currentColor" d="M14.5 2h-13l-.5.5v9l.5.5H4v2.5l.854.354L7.707 
                    12H14.5l.5-.5v-9l-.5-.5zm-.5 9H7.5l-.354.146L5 13.293V11.5l-.5-.5H2V3h12v8z" />
                    </g>
                </svg>
            </div>

            <div class="box box4">
                <div class="text">
                    <h2 class="topic-heading">70</h2>
                    <h2 class="topic">Publicados</h2>
                </div>
                <svg width="56px" height="56px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <path fill="currentColor" fill-rule="evenodd" d="m14.431 3.323l-8.47 10l-.79-.036l-3.35-4.77l.818-.574l2.978 
                    4.24l8.051-9.506l.764.646z" clip-rule="evenodd" />
                    </g>
                </svg>
            </div>
        </div>

        <table class="table px-4 mt-5">
            <thead>
                <div class="report-header">
                    <h2 class="mx-auto">Articulos publicados</h2>
                    <button class="products-btn" onclick="getDisabledProds()">Ver productos desactivados
                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 12l-7-9v4.99L3 8v8h11v5z" />
                    </svg>
                    </button>
                </div>
                <hr>
                <tr class="table-headers">
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Desactivar</th>
                </tr>
            </thead>
            <tbody id="row-of-products">
                <?php
                if (isset($productos) && !empty($productos)) {
                    foreach ($data['productos'] as $prod) {
                        echo "
            <tr>
            <th>" . htmlentities($prod["id"]) . "</th>
            <td>" . htmlentities($prod["titulo"]) . " </td>
            <td>" . htmlentities($prod["origen"]) . "</td>
            <td>" . htmlentities($prod["precio"]) . "</td>
            <td>Publicado</td>
            <td> 
            <button class='button-product-actions edit' data-product-id=" . $prod['id'] . " onclick='showEditForm(this)'> 
            <svg xmlns='http://www.w3.org/2000/svg' width='40px' height='40px' viewBox='0 0 24 24'><g fill='none' 
            stroke='currentColor' 
            stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5'>
            <path d='M9.533 11.15A1.82 1.82 0 0 0 9 12.438V15h2.578c.483 0 .947-.192 1.289-.534l7.6-7.604a1.82 1.82 0 0 0 0-2.577l-.751-.751a1.82 1.82 0 0 0-2.578 0z'/>
            <path d='M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3'/></g></svg>
            </button></td>
            <td>
            <button class='button-product-actions delete' data-product-id=" . $prod['id'] . " onclick='disableProduct(event, this)'> 
            <svg xmlns='http://www.w3.org/2000/svg' width='40px' height='40px' viewBox='0 0 24 24'><path fill='currentColor' d='M12 7c2.76 0 5 2.24 5 5c0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7M2 4.27l2.28 2.28l.46.46A11.8 11.8 0 0 0 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22L21 20.73L3.27 3zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65c0 1.66 1.34 3 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53c-2.76 0-5-2.24-5-5c0-.79.2-1.53.53-2.2m4.31-.78l3.15 3.15l.02-.16c0-1.66-1.34-3-3-3z'/>
            </svg>
            </button> </td>
            </tr>
            ";
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="product-form">
            
            <div id="edit_product_modal" class="modal">
                <div class="modal-content">
                    <h4>Editar Producto</h4>
                    <form class="form_edit_product" id="edit_product_form" method="post">
                        <input type="hidden" id="edit_product_id" name="id_producto">

                        <label for="new_titulo">Título:</label>
                        <input type="text" id="new_titulo" name="new_titulo" required>

                        <label for="new_descripcion">Descripción:</label>
                        <textarea id="new_descripcion" name="new_descripcion" required></textarea>

                        <label for="new_origen">Origen:</label>
                        <input type="text" id="new_origen" name="new_origen" required>

                        <label for="new_cantidad">Cantidad:</label>
                        <input type="number" id="new_cantidad" name="new_cantidad" required>

                        <label for="new_precio">Precio:</label>
                        <input type="number" id="new_precio" name="new_precio" required>

                        <button type="submit" onclick="submitEditForm(event)">Actualizar</button>
                        <button type="button" onclick="closeEditForm()">Cancelar</button>
                    </form>
                </div>
            </div>


            <div id="loading-products-spinner" class="container-load-products">
                <div class="wrapper">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="shadow"></div>
                    <div class="shadow"></div>
                    <div class="shadow"></div>
                </div>
                <button id="btn-load-prods" onclick="loadMoreProducts(this)" class="products-btn">Cargar más
                    <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 12l-7-9v4.99L3 8v8h11v5z" />
                    </svg>
                </button>
            </div>
            <form
                id="add_product_form"
                action="?action=agregar_producto"
                method="POST"
                enctype="multipart/form-data"
                class="form-product">
                <input type="hidden" name="id_usu_ven" value="">
                <label for="titulo">Nombre del producto</label>
                <input id="titulo" placeholder="Título del producto" type="text" name="nombre" required>

                <label for="descr">Descripción</label>
                <input id="descr" placeholder="Descripción del producto" type="text" name="descripcion" required>

                <label for="origen">Origen</label>
                <input type="text" placeholder="Origen del producto" name="origen" id="origen" required>

                <label for="category">Categoría</label>
                <select name="acategory" id="category">
                    <option value="">Selecciona una categoría</option>
                    <?php  if (isset($data['categorias']) && !empty($data['categorias'])) {
                        foreach ($data['categorias'] as $category) {
                            echo '<option value="'. $category['id_categorias'] .'">
                             '.$category['Nombre'].'</option>';
                        }
                    }
                    ?>
                </select>

                <label for="stock">Cantidad de unidades</label>
                <input type="text" placeholder="Stock del producto" name="stock" id="stock" required>

                <label for="precio">Precio</label>
                <input id="precio" placeholder="Precio del producto en pesos" type="text" name="precio" required>

                <label for="images">Imágenes del producto (máximo 6)</label>
                <input type="file" name="images[]" id="images" accept="image/*" multiple required>


                <button class="send-product" name="submit" onclick="productsForm()" type="button">Agregar producto</button>
            </form>
            <div id="sub-product" class="added-product">
                <p></p>
                <svg onclick="this.parentElement.style.display=`none`" ;
                    width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor"
                    x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <g fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M15 15L9 9m6 0l-6 6" />
                            <circle cx="12" cy="12" r="10" />
                        </g>
                    </g>
                </svg>

            </div>
        </div>

        <canvas id="companyCharts" class="canvas-container"></canvas>
    </div>
</div>

<?php
include('footeradm.php');
?>