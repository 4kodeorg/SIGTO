<?php
include 'header-index.php';

?>

<div class="container-checkout-page px-2">

<table class="table">
  <thead>
    <tr>
      <th colspan="2">Datos de facturación</th> 
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Nombre:</th>
      <td><?= $data['usuario']['name']?> <?= $data['usuario']['lastname']?></td> 
    </tr>
    <tr>
      <th>Email:</th>
      <td><?= $data['usuario']['email']?></td> 
    </tr>
    <tr>
      <th>Teléfono:</th>
      <td><?= $data['usuario']['telefono']?></td> 
    </tr>
  </tbody>
</table>


<section class="section-items-checkout" >
    <h4 class="heading-items-checkout">Mis artículos </h4>
    <?php
    $totalCart = 0;
        foreach ($data['carrito'] as $item) {
            $totalCart += $item['price_product'] * $item['cantidad'];
            echo '<div class="container-fluid mt-2">
                <h5>'. $item['titulo'].'</h5>
                <h5>Cantidad: '. $item['cantidad'].'</h5>
                <b>P/U: '. $item['price_product'] .' </b> 
                </div>
                <hr>';
        }

    ?>
    <p class="text-end">Total de compra:<b>$<?= $totalCart ?> </b> </p>
</section>

</div>

<section>

<div id="paypal-button-container"></div>
    <p id="result-message"></p>

</section>

<?php 
include 'footer.php';
?>