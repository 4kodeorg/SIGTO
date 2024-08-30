<?php
// session_start();
// if(isset($_SESSION['username'])) {
require('./headerback.php')
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

            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Articulos recientes</h1>
                    <button class="view">Ver todos</button>
                </div>

                <div class="report-body">


                    </div>
                </div>
            </div>
            </div>
</div>
</div>

<?php
// } else {
//     header('Location: ../../index.php');
//     exit();
// }
?>