<?php
include 'header-index.php';

?>
<div class="container-checkout-grid">
<div class="container-checkout-page px-2">
<div class="border border-success p-3">
<table class="table">
  <thead>
    <tr>
      <th colspan="2">Datos de facturación</th> 
    </tr>
  </thead>
  <tbody>
    <tr>
     
      <th>Nombre:</th>
      <td><?php echo $data['usuario']['nombre1']. $data['usuario']['apellido1']?></td> 
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $data['usuario']['email']?></td> 
    </tr>
    <tr>
      <th>Teléfono:</th>
      <?php if (isset($data['usuario_telefono']['telefono'])) {
        echo "<td>".$data['usuario_telefono']['telefono']." </td";
      } else {
        echo '<td>Para agregar un número de telefono ve a <a class="badge text-bg-success" href=/perfil/'.bin2hex($data['usuario']['email']).'><b>Mi Perfil</b></a></td>';
      }
      ?>
      
    </tr>
  </tbody>
</table>
</div>

<section class="border p-3 border-warning section-items-checkout" >
    <h4 class="badge rounded-pill text-bg-warning fs-4 heading-items-checkout">Mis artículos </h4>
    <?php
    $totalCart = 0;
        foreach ($data['carrito'] as $item) {
            $totalCart += $item['precio_prod'] * $item['cantidad'];
            echo '
            <div id="container-id" data-product-id="'.$item['sku_prod'].'"> </div>
            <form id="form-product-checkout'.$item['sku_prod'].'" class="container-fluid mt-2">
                <label>'. $item['titulo'].'</label>
                <input type="hidden" name="titulo" value="'. $item['titulo'].'">
                <label>Cantidad: '. $item['cantidad'].'</label>
                <input type="hidden" name="cantidad" value="'.$item['cantidad'].'">
                <label>P/U: '. $item['precio_prod'] .' </label>
                <input type="hidden" name="price_product" value="'. $item['precio_prod'] .'"> 
                </form>
                <hr>';
        }

    ?>
    <p class="total-cart-ch text-end">Total de compra:<b>$<?= $totalCart ?> </b> </p>
</section>

</div>
<section>
  <p class="py-3 text-center">Selecciona un método de entrega</p>
<form action="">
<input type="radio" id="envio" name="metodo_entrega" value="Envio" onchange="toggleDeliveryOptions(this)">
 <label for="envio">Envio a domicilio</label><br>
 <input type="radio" id="pickup" name="metodo_entrega" value="Pick-Up" onchange="togglePickUpOptions(this)">
 <label for="pickup">Pick-Up en local</label><br>

 <div id="envio-container-options">

 </div>

 <div id="pickup-container-options">

 </div>
</form>
<div id="paypal-button-container"></div>
    <p id="result-message"></p>

</section>

    </div>
<?php 
include 'footer.php';
?>