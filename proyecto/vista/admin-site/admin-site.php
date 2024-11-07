<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']) && isset($_POST['action'])) {
    $email = $_POST['email'];
    $action = $_POST['action'];
    require_once $_SERVER['DOCUMENT_ROOT'] .'/controlador/AdminController.php';
    $admin = new AdminController();
    if ($action == 'suspend') {
        if ($admin->suspendClienteAcc($email)) {
            $mess = "Cuenta suspendida";
            header('refresh:2');
        }
    }
    if ($action == 'unsuspend') {
        if ($admin->unsuspendCliente($email)) {
            $mess = "Cuenta re-activada";
            header('refresh:2');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGTO - ADMINISTRACIÓN</title>
</head>
<body>
    <h1 class="badge text-center"></h1>
    <div>
        <table class="table">
            <thead>
                <th>Email</th>
                <th>Usuario</th>
                <th>Fecha De Registro</th>
                <th>Suspendido</th>
            </thead>
         <tbody>
         <?php 
            $clientes = $data['clientes'];
            foreach ($clientes as $cli) {
                if ($cli['suspended'] == 0) {
                    $suspended = "No";
                } else {
                    $suspended = "Si";
                }
                echo '<tr> 
                    <td>'. $cli['email'].'</td>
                    <td>'.$cli['username']. '</td>

                    <td>'.$cli['fecha_registro']. '</td>

                    <td>'.$suspended. '</td>
                    <td>';
            
                    ?>
                    <form action="admin-site.php" method="post">
                    <input type="hidden" name="email" value="'.$cli['email'].'">
                    <?php if ($cli['suspended'] == 1): ?>
                                <button type="submit" name="action" value="unsuspend">Activar</button>
                            <?php else: ?>
                                <button type="submit" name="action" value="suspend">Suspender</button>
                            <?php endif; ?>
                    </form>
                    </td>
                </tr>
               <?php
            }
            ?>
         </tbody>
        </table>
        <div> </div>
    </div>
            <a href="/logout">Cerrar sesión</a>
</body>
</html>