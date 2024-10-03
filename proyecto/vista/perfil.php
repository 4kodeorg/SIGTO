<?php
include('header-index.php');
?>

<div class="container-profile-page">
    <div class="container-sidenav-profile">
        <nav class="nav-sidenav fixed-left" onmouseover="goLeft()" onmouseout="getBack()">
            <div class="settings-place"></div>
            <div class="scroll-place" id="scroll-container">
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="M6.133 21C4.955 21 4 20.02 4 18.81v-8.802c0-.665.295-1.295.8-1.71l5.867-4.818a2.09 2.09 0 0 1 2.666 0l5.866 4.818c.506.415.801 1.045.801 1.71v8.802c0 1.21-.955 2.19-2.133 2.19z" />
                            <path d="M9.5 21v-5.5a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2V21" />
                        </g>
                    </svg>
                    <span class="span-sidenav-text">Inicio</span>
                </a>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.935 7H7.773c-1.072 0-1.962.81-2.038 1.858l-.73 10C4.921 20.015 5.858 21 7.043 21h9.914c1.185 0 2.122-.985 2.038-2.142l-.73-10C18.189 7.81 17.299 7 16.227 7h-1.162m-6.13 0V5c0-1.105.915-2 2.043-2h2.044c1.128 0 2.043.895 2.043 2v2m-6.13 0h6.13" />
                    </svg>
                    <span class="span-sidenav-text">Compras</span>
                </a>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79" />
                    </svg>
                    <span class="span-sidenav-text">Favoritos</span>
                </a>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="M3 9.4c0-2.24 0-3.36.436-4.216a4 4 0 0 1 1.748-1.748C6.04 3 7.16 3 9.4 3h5.2c2.24 0 3.36 0 4.216.436a4 4 0 0 1 1.748 1.748C21 6.04 21 7.16 21 9.4v5.2c0 2.24 0 3.36-.436 4.216a4 4 0 0 1-1.748 1.748C17.96 21 16.84 21 14.6 21H9.4c-2.24 0-3.36 0-4.216-.436a4 4 0 0 1-1.748-1.748C3 17.96 3 16.84 3 14.6z" />
                            <path d="M14.5 9.25a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0M7 20.5v-1.3c.317-6.187 9.683-6.187 10 0v1.3" />
                        </g>
                    </svg>
                    <span class="span-sidenav-text">Mi perfil</span>
                </a>
                <a href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="M21 12a9 9 0 1 1-18 0a9 9 0 0 1 18 0" />
                            <path d="M12 13.496c0-2.003 2-1.503 2-3.506c0-2.659-4-2.659-4 0m2 6.007v-.5" />
                        </g>
                    </svg>
                    <span class="span-sidenav-text">Ayuda</span>
                </a>
            </div>
        </nav>
    </div>
    <div class="profile-section-page">
        <div class="user-profile">
            <a href="">
                <figure class="figure-profile-icon">
                    <img src="../assets/imgs/profile.svg" alt="">
                    <figcaption> <?php echo htmlspecialchars($usuario['name']) ?> <?php echo htmlspecialchars($usuario['lastname']) ?></figcaption>
                </figure>
            </a>


        </div>

        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Información personal <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <circle cx="9" cy="10" r="2" fill="currentColor" opacity="0.3" />
                            <path fill="currentColor" d="M14.48 18.34C13.29 17.73 11.37 17 9 17s-4.29.73-5.48 1.34C2.9 18.66 3 19.28 3 20h12c0-.71.11-1.34-.52-1.66" opacity="0.3" />
                            <path fill="currentColor" d="M21 3H3c-1.1 0-2 .9-2 2v8h2V5h18v16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2" />
                            <path fill="currentColor" d="M13 10c0-2.21-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4m-6 0c0-1.1.9-2 2-2s2 .9 2 2s-.9 2-2 2s-2-.9-2-2m8.39 6.56C13.71 15.7 11.53 15 9 15s-4.71.7-6.39 1.56A2.97 2.97 0 0 0 1 19.22V22h16v-2.78c0-1.12-.61-2.15-1.61-2.66M15 20H3c0-.72-.1-1.34.52-1.66C4.71 17.73 6.63 17 9 17s4.29.73 5.48 1.34c.63.32.52.95.52 1.66" />
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <p>Usuario: <?php echo htmlspecialchars($usuario['username']) ?></p>
                        <p>Correo: <?php echo htmlspecialchars($usuario['email']) ?></p>
                        <p>Número de teléfono: <?php echo htmlspecialchars($usuario['telefono']) ?></p>

                        <button onclick="showNow()"> Actualizar información </button>

                        <div id="actualizar-info">
                        <form 
                        id="form-personal-info"
                        action="?action=actualizar_info" 
                        method="POST">
                            <input type="hidden" name="idusername" value="<?php echo htmlspecialchars($usuario['id']) ?>">
                            <label for="newuser">Usuario</label>
                            <input type="text" id='newuser' name='new_user' placeholder="Nombre de usuario">
                            <label for="newcorreo">Correo</label>
                            <input type="text" id='newcorreo' name='new_correo' placeholder="Dirección de correo">
                            <label for="newphone">Telefono</label>
                            <input type="text" id='newphone' name='new_telefono' placeholder="Número de telefono">
                            <button type="button" name="submit" onclick="updateInfo()">Actualizar</button>
                    </form>       
                    <button onclick="hideNow()">Ocultar</button> 
                    </div>

                    <div class="container-response-mssg" id="message-resp-info">
            <p></p>
            <svg onclick="this.parentElement.style.display=`none`;"
                width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor"
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                <g fill="currentColor">
                    <g fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M15 15L9 9m6 0l-6 6" />
                        <circle cx="12" cy="12" r="10" />
                    </g>
                </g>
            </svg>
        </div> 
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Mis direcciones <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88c2.11-2.69 5-7 5-9.88c0-2.76-2.24-5-5-5m0 7.5a2.5 2.5 0 0 1 0-5a2.5 2.5 0 0 1 0 5" opacity="0.3" />
                            <path fill="currentColor" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7M7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9" />
                            <circle cx="12" cy="9" r="2.5" fill="currentColor" />
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <?php if (isset($usuario['direccion']) && isset($usuario['seg_direccion'])) {
                            echo '
            <p>Dirección de envío: ' . $usuario['direccion'] . '</p>

            <p>Direccion de envío alternativa: ' . $usuario['seg_direccion'] . ' </p>
            ';  ?>
            <button onclick="showFormDir()">Actualizar mis direcciones</button>
            
            <div id="actualizar-direcciones-container">
            <form
            id="form-direcciones"
            action="/perfil/' . $usuario['id'] . '?action=actualizar_direccion"
            method="POST">
            <input type="hidden" name="idusername" value="<?php echo htmlspecialchars($usuario['id']) ?>">
            <label for="direccion_envio">Dirección de envío</label>
            <input type="text" name="direccion" placeholder="Dirección de envío">
            <label for="">Dirección de envío alternativa</label>
            <input type="text" name="seg_direccion" placeholder="Dirección alternativa (opcional)">

            <button type="button" name="submit" onclick="updateDirecciones()">Actualizar</button>
            </form> 
            <button onclick="hideForm()"> Ocultar </button>
            </div>
            
        
        <div class="container-response" id="message-resp-direcciones">
            <p></p>
            <svg onclick="this.parentElement.style.display=`none`;"
                width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor"
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                <g fill="currentColor">
                    <g fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M15 15L9 9m6 0l-6 6" />
                        <circle cx="12" cy="12" r="10" />
                    </g>
                </g>
            </svg>
        </div> <?php
               } else {
                        echo '
                            <p>Debes agregar al menos una dirección para continuar comprando </p>
                            ';
                        } ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Medios de pago <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h10v-2H4v-6h18V6c0-1.11-.89-2-2-2m0 4H4V6h16zm4 9v2h-3v3h-2v-3h-3v-2h3v-3h2v3z" />
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                </div>
            </div>
        </div>
        <?php
        if (!isset($usuario['direccion'])) {
            echo '<form
            id="form-direcciones"
            action="/perfil/' . $usuario['id'] . '?action=actualizar_direccion"
            method="POST">
            <label for="direccion_envio">Dirección de envío</label>
            <input type="text" name="direccion" placeholder="Dirección de envío">
            <label for="">Dirección de envío alternativa</label>
            <input type="text" name="seg_direccion" placeholder="Dirección alternativa (opcional)">

            <button type="button" name="submit" onclick="updateDirecciones()">Actualizar</button>
        </form>';
        } else {
            echo '<div>
            <h5>Estás al dia con tu perfil!</h5>
            </div>';
        }

        ?>
        <div class="container-response" id="message-resp-direcciones">
            <p></p>
            <svg onclick="this.parentElement.style.display=`none`;"
                width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor"
                x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                <g fill="currentColor">
                    <g fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M15 15L9 9m6 0l-6 6" />
                        <circle cx="12" cy="12" r="10" />
                    </g>
                </g>
            </svg>
        </div>
    </div>
</div>


<?php

include('footer.php');
