<?php
// LAS RUTAS DEL BACK OFFICE SON RUTAS PROTEGIDAS SE VERIFICA LA SESION ANTES DE PERMITIR ACCESO
// session_start();

// if(isset($_SESSION['username'])) {
require('./headerback.php');
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
                    <h1 class="recent-Articles">Articulos recientes</h1>
                    <button class="view">Ver todos</button>
                </div>

                <div class="report-body">
                    <div class="report-topic-heading">
                        <h3 class="t-op">Articulo</h3>
                        <h3 class="t-op">Visitas</h3>
                        <h3 class="t-op">Comentarios</h3>
                        <h3 class="t-op">Estado</h3>
                    </div>

                    <div class="items">
                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 73</h3>
                            <h3 class="t-op-nextlvl">2.9k</h3>
                            <h3 class="t-op-nextlvl">210</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 72</h3>
                            <h3 class="t-op-nextlvl">1.5k</h3>
                            <h3 class="t-op-nextlvl">360</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 71</h3>
                            <h3 class="t-op-nextlvl">1.1k</h3>
                            <h3 class="t-op-nextlvl">150</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 70</h3>
                            <h3 class="t-op-nextlvl">1.2k</h3>
                            <h3 class="t-op-nextlvl">420</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 69</h3>
                            <h3 class="t-op-nextlvl">2.6k</h3>
                            <h3 class="t-op-nextlvl">190</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 68</h3>
                            <h3 class="t-op-nextlvl">1.9k</h3>
                            <h3 class="t-op-nextlvl">390</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 67</h3>
                            <h3 class="t-op-nextlvl">1.2k</h3>
                            <h3 class="t-op-nextlvl">580</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 66</h3>
                            <h3 class="t-op-nextlvl">3.6k</h3>
                            <h3 class="t-op-nextlvl">160</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Article 65</h3>
                            <h3 class="t-op-nextlvl">1.3k</h3>
                            <h3 class="t-op-nextlvl">220</h3>
                            <h3 class="t-op-nextlvl label-tag">Publicado</h3>
                        </div>

                    </div>
                </div>
            </div>
            </div>
</div>
</div>
<?php 
// } else {
//     // SI EL USUARIO NO ESTA AUTENTICADO / AUTORIZADO SE REDIRECCIONA A UNA RUTA PUBLICA
//     header('Location: ../../index.php');
//     exit();
// }
?>