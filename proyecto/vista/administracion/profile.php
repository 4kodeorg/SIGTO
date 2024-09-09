<?php
// RUTAS PROTEGIDAS
// session_start();
// if(isset($_SESSION['username'])) {
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
</div>

<?php
// }
// else {
//     header('Location: ../../index.php');
//     exit();
// }
?>