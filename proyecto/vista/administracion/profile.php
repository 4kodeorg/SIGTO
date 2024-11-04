<?php

require('headerback.php')
?>

<div class="main-container">

    <div class="main">
        <div class="box-container">

        </div>

        <div class="report-container">
            <div class="report-header">
                <h1 class="recent-Articles">Información del perfil</h1>
                <button class="view">Modificar</button>
            </div>
        </div>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Nombre</th>

            <th scope="col">Apellido</th>

            <th scope="col">Correo</th>

            <th scope="col">Razón social</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                <?php echo $data['vendedor']['nombre'] ?>
            </td>
            <td>
                <?php echo $data['vendedor']['apellido'] ?>
            </td>
            <td>
                <?php echo $data['vendedor']['email'] ?>
            </td>
            <td>
                <?php echo $data['vendedor']['razon_social'] ?>
            </td>
        </tr>
    </tbody>
</table>
<table class="table">
    <thead>
        <?php
        if (isset($data['productos']) && count($data['productos']) > 0) {
            ?>
        <th colspan="6">Productos publicados</th>
        <tr class="table-headers">
                    <th scope="col">Titulo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Estado</th>
                </tr>
    </thead>
    <tbody>
        
        <?php
        
        foreach($data['productos'] as $prod) {
        echo '<tr>
            <td>' .$prod["nombre"].'</td>
            <td> ' .$prod["descripcion"].' </td>
            <td>' .$prod["origen"].' </td>
            <td>' .$prod["stock"].' </td>
            <td> ' .$prod["precio"].' </td>
            <td>
                '. $prod["estado"].'
            </td>
        </tr>';
            }
        } else {
        ?>
        <tr>
            <td colspan="4">No tienes productos publicados aun</td>
        </tr>
        <?php }?>
    </tbody>
</table>
</div>
<?php
include('footeradm.php');
?>