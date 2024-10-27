<?php
include 'header-index.php';

?>
<div class="container-checkout-grid">
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
            echo '
            <div id="container-id" data-product-id="'.$item['id'].'"> </div>
            <form id="form-product-checkout'.$item['id'].'" class="container-fluid mt-2">
                <label>'. $item['titulo'].'</label>
                <input type="hidden" name="titulo" value="'. $item['titulo'].'">
                <label>Cantidad: '. $item['cantidad'].'</label>
                <input type="hidden" name="cantidad" value="'.$item['cantidad'].'">
                <label>P/U: '. $item['price_product'] .' </label>
                <input type="hidden" name="price_product" value="'. $item['price_product'] .'"> 
                </form>
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
<script>
    const userId = <?= $data['usuario']['id'];?>;
    const totalAmmount = <?= $totalCart; ?>;
</script>
    </div>
<?php 
include 'footer.php';
?>