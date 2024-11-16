<?php
include 'header-index.php';

?>
<div class="container-checkout-grid">
<div class="container-checkout-page px-2">
<div class="border border-success p-3">
<table class="table">
  <thead>
    <tr>
      <th class="badge rounded-pill text-bg-success" colspan="2">Datos de facturación</th> 
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
                <input type="hidden" name="id_user_comp" value="'.$item['id_usu_com'].'">
                <input type="hidden" name="id_user_vend" value="'. $item['id_usu_ven'] .'">
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
<section class="pay-and-deliver">
  <p class="py-3 text-center">Selecciona un método de entrega</p>
<form 
  action=""
  id="form-metodo-envio"
  class="">
<input type="radio" id="envio" name="metodo_entrega" value="Envio" onchange="toggleDeliveryOptions(this)" required>
 <label for="envio">Envio a domicilio</label><br>
 <input type="radio" id="pickup" name="metodo_entrega" value="Pick-Up" onchange="togglePickUpOptions(this)" required>
 <label for="pickup">Pick-Up en local</label><br>

 <div id="envio-container-options" class="input-direcciones">
  <span class="badge text-bg-success">Mis direcciones</span>
 <?php if (isset($data['comp_direcciones'])) {
    $direcciones = $data['comp_direcciones'];
   
    foreach ($direcciones as $dir) {
      echo '<input type="radio" id="mis_direcciones" name="dir_envio" value="'.$dir['id_direccion'].'" onchange="toggleTipoVehiculo(this)" required>
        <label for="mis_direcciones">'. $dir['calle_pri'] . $dir['num_puerta'].'</label>';
    }
 }
 ?> 
 </div>
 <div class="container-vehiculo-select" id="select-option-vehiculo">
 <small class="small-caption-eco text-center">Seleccionando un vehículo que no produzca emisiones sos elegible para recibir un cupón de 10% off en lo que quieras 
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
    <path fill="currentColor" d="M6.05 8.05a7 7 0 0 0-.02 9.88c1.47-3.4 4.09-6.24 7.36-7.93A15.95 15.95 0 0 0 8 19.32c2.6 1.23 5.8.78 7.95-1.37C19.43 14.47 20 4 20 4S9.53 4.57 6.05 8.05"/>
</svg></small>
  <label for="tipo_vehiculo">Tipo de vehículo</label>
  
  <select name="tipo_vehiculo" id="tipo_vehiculo" onchange="getFootPrintCo2(this);">
    <option value="">Seleccionar tipo de vehículo</option>
    <option value="Electrico">Electrico</option>
    <option value="Nafta">Combustión</option>
  </select>
  <small id="co2foot" class="small-caption-eco"></small>
 </div>

 <div id="pickup-container-options" class="input-pickup">
      <section><p>Retirar en : Jose Enrique Rodó 1723</p>
      <p>Horario: Lunes a Viernes 08:00 - 17:00</p></section>
 </div>
<button class="button-confirm-dir" type="button" name="submit" onclick="confirmMetodoEnvio(this, event)">Confirmar método de envío</button>
</form>
<p class="">Pagar con</p>
<?php if (isset($data['pago_comp']) && !empty($data['pago_comp'])) {
  $tarjetas = $data['pago_comp'];
  foreach ($tarjetas as $info) {
    echo '<input type="radio" id="card_nom" name="card_nom" value="'.$info['nombre_tarjeta'].'">
      <label for="card_nom">'. $info['nombre_tarjeta'].'</label>';

  }
  
  }
  else {
    echo '<p class="badge text-bg-danger small-caption-eco">No tienes ningún medio de pago asociado a tu cuenta</p>';
  } ?>
  <button 
    class="button-pay-paypal"
    onclick="togglePaypalButton()">Pagar con paypal 
    <svg xmlns="http://www.w3.org/2000/svg" width="0.85em" height="1em" viewBox="0 0 256 302"><path fill="#27346a" d="M217.168 23.507C203.234 7.625 178.046.816 145.823.816h-93.52A13.39 13.39 0 0 0 39.076 12.11L.136 259.077c-.774 4.87 2.997 9.28 7.933 9.28h57.736l14.5-91.971l-.45 2.88c1.033-6.501 6.593-11.296 13.177-11.296h27.436c53.898 0 96.101-21.892 108.429-85.221c.366-1.873.683-3.696.957-5.477q-2.334-1.236 0 0c3.671-23.407-.025-39.34-12.686-53.765"/>
    <path fill="#27346a" d="M102.397 68.84a11.7 11.7 0 0 1 5.053-1.14h73.318c8.682 0 16.78.565 24.18 1.756a102 102 0 0 1 6.177 1.182a90 90 0 0 1 8.59 2.347c3.638 1.215 7.026 2.63 10.14 4.287c3.67-23.416-.026-39.34-12.687-53.765C203.226 7.625 178.046.816 145.823.816H52.295C45.71.816 40.108 5.61 39.076 12.11L.136 259.068c-.774 4.878 2.997 9.282 7.925 9.282h57.744L95.888 77.58a11.72 11.72 0 0 1 6.509-8.74"/>
    <path fill="#2790c3" d="M228.897 82.749c-12.328 63.32-54.53 85.221-108.429 85.221H93.024c-6.584 0-12.145 4.795-13.168 11.296L61.817 293.621c-.674 4.262 2.622 8.124 6.934 8.124h48.67a11.71 11.71 0 0 0 11.563-9.88l.474-2.48l9.173-58.136l.591-3.213a11.71 11.71 0 0 1 11.562-9.88h7.284c47.147 0 84.064-19.154 94.852-74.55c4.503-23.15 2.173-42.478-9.739-56.054c-3.613-4.112-8.1-7.508-13.327-10.28c-.283 1.79-.59 3.604-.957 5.477"/>
    <path fill="#1f264f" d="M216.952 72.128a90 90 0 0 0-5.818-1.49a110 110 0 0 0-6.177-1.174c-7.408-1.199-15.5-1.765-24.19-1.765h-73.309a11.6 11.6 0 0 0-5.053 1.149a11.68 11.68 0 0 0-6.51 8.74l-15.582 98.798l-.45 2.88c1.025-6.501 6.585-11.296 13.17-11.296h27.444c53.898 0 96.1-21.892 108.428-85.221c.367-1.873.675-3.688.958-5.477q-4.682-2.47-10.14-4.279a83 83 0 0 0-2.77-.865"/></svg>
  </button>
<form>
<div id="paypal-button-container" class="hide-pp-btn"></div>
    <p id="result-message"></p>
</form>
</section>

    </div>
<?php 
include 'footer.php';
?>