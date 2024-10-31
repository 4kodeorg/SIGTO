<?php

require('headerback.php')
?>

<div class="main-container">

    <div class="main">

        <div class="searchbar2">
            <input type="text" name="" id="" placeholder="Search">
            <div class="searchbtn">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                    <g fill="currentColor">
                        <path fill="currentColor" d="M15.25 0a8.25 8.25 0 0 0-6.18 13.72L1 22.88l1.12 
                    1l8.05-9.12A8.251 8.251 0 1 0 15.25.01V0zm0 15a6.75 6.75 0 1 1 0-13.5a6.75 6.75 
                    0 0 1 0 13.5z" />
                    </g>
                </svg>
            </div>
        </div>

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
        <th colspan="6">Productos publicados</th>
    </thead>
    <tbody>
        
        <?php
        if (isset($data['productos']) && count($data['productos']) > 0) {
        foreach($data['productos'] as $prod) {
        ?>
        <tr>
            <td><?php $prod['nombre']?></td>
            <td> <?php $prod['descripcion'] ?></td>
            <td><?php $prod['origen'] ?></td>
            <td><?php $prod['stock']?></td>
            <td> <?php $prod['precio']?></td>
            <td>
                <?php $prod['estado']?>
            </td>
        </tr>
        <?php
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