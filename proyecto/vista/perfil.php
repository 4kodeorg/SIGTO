<?php
include('header-index.php');
?>

<div class="container-profile-page">
    <div class="container-sidenav-profile">
        <nav class="nav-sidenav fixed-left" onmouseover="goLeft()" onmouseout="getBack()">
            <div class="settings-place"></div>
            <div class="scroll-place" id="scroll-container">
                <a href="/perfil/<?php echo bin2hex($usuario['email']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="M3 9.4c0-2.24 0-3.36.436-4.216a4 4 0 0 1 1.748-1.748C6.04 3 7.16 3 9.4 3h5.2c2.24 0 3.36 0 4.216.436a4 4 0 0 1 1.748 1.748C21 6.04 21 7.16 21 9.4v5.2c0 2.24 0 3.36-.436 4.216a4 4 0 0 1-1.748 1.748C17.96 21 16.84 21 14.6 21H9.4c-2.24 0-3.36 0-4.216-.436a4 4 0 0 1-1.748-1.748C3 17.96 3 16.84 3 14.6z" />
                            <path d="M14.5 9.25a2.5 2.5 0 1 1-5 0a2.5 2.5 0 0 1 5 0M7 20.5v-1.3c.317-6.187 9.683-6.187 10 0v1.3" />
                        </g>
                    </svg>
                    <span class="span-sidenav-text">Mi perfil</span>
                </a>
                <a href="/home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                            <path d="M6.133 21C4.955 21 4 20.02 4 18.81v-8.802c0-.665.295-1.295.8-1.71l5.867-4.818a2.09 2.09 0 0 1 2.666 0l5.866 4.818c.506.415.801 1.045.801 1.71v8.802c0 1.21-.955 2.19-2.133 2.19z" />
                            <path d="M9.5 21v-5.5a2 2 0 0 1 2-2h1a2 2 0 0 1 2 2V21" />
                        </g>
                    </svg>
                    <span class="span-sidenav-text">Inicio</span>
                </a>
                <button
                    onclick="getUserCompras(event, this)"
                    data-user-id="<?php echo bin2hex($usuario['email']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.935 7H7.773c-1.072 0-1.962.81-2.038 1.858l-.73 10C4.921 20.015 5.858 21 7.043 21h9.914c1.185 0 2.122-.985 2.038-2.142l-.73-10C18.189 7.81 17.299 7 16.227 7h-1.162m-6.13 0V5c0-1.105.915-2 2.043-2h2.044c1.128 0 2.043.895 2.043 2v2m-6.13 0h6.13" />
                    </svg>
                    <span class="span-sidenav-text">Compras</span>
                </button>
                <button

                    onclick="getFavorites(event, this)"
                    data-user-id="<?php echo bin2hex($usuario['email']) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79" />
                    </svg>
                    <span class="span-sidenav-text">Favoritos</span>
                </button>

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
   
    <div class="profile-section-page" id="profile-section-items">
        <div class="user-profile">
            <a href="">
                <figure class="figure-profile-icon">
                    <img src="../assets/imgs/ilustrationsd/profile.svg" alt="">
                    <figcaption> <?php echo htmlspecialchars($usuario['email']) ?>
                        <?php echo htmlspecialchars($usuario['username']) ?></figcaption>
                </figure>
            </a>
        </div>
        <div id="compras-cont"></div>
        <div id="favorites-container"></div>
        <div class="accordion accordion-flush" id="accordionFlushContainer">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button id="accordion-button" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        <span>
                            Información personal
                        </span> <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <circle cx="9" cy="10" r="2" fill="currentColor" opacity="0.3" />
                            <path fill="currentColor" d="M14.48 18.34C13.29 17.73 11.37 17 9 17s-4.29.73-5.48 1.34C2.9 18.66 3 19.28 3 20h12c0-.71.11-1.34-.52-1.66" opacity="0.3" />
                            <path fill="currentColor" d="M21 3H3c-1.1 0-2 .9-2 2v8h2V5h18v16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2" />
                            <path fill="currentColor" d="M13 10c0-2.21-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4s4-1.79 4-4m-6 0c0-1.1.9-2 2-2s2 .9 2 2s-.9 2-2 2s-2-.9-2-2m8.39 6.56C13.71 15.7 11.53 15 9 15s-4.71.7-6.39 1.56A2.97 2.97 0 0 0 1 19.22V22h16v-2.78c0-1.12-.61-2.15-1.61-2.66M15 20H3c0-.72-.1-1.34.52-1.66C4.71 17.73 6.63 17 9 17s4.29.73 5.48 1.34c.63.32.52.95.52 1.66" />
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushContainer">
                    <div class="accordion-body">
                        <table class="user-info-table">
                            <tr>
                                <th>Usuario</th>
                                <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                            </tr>
                            <tr>
                                <th>Correo</th>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            </tr>
                            <tr>
                                <th>País</th>
                                <td><?php echo htmlspecialchars($usuario['pais']); ?></td>
                            </tr>
                            <?php if (isset($data['comprador']['nombre1'])) { ?>
                                <tr>
                                    <th>Nombre completo</th>
                                    <td><?php echo htmlspecialchars($data['comprador']['nombre1'] . ' ' . $data['comprador']['nombre2']); ?></td>
                                </tr>
                                <tr>
                                    <th>Apellidos</th>
                                    <td><?php echo htmlspecialchars($data['comprador']['apellido1'] . ' ' . $data['comprador']['apellido2']); ?></td>
                                </tr>
                                <?php if (isset($data['userphone']['telefono'])) { ?>
                                    <tr>
                                        <th>Número de teléfono</th>
                                        <td><?php echo htmlspecialchars($data['userphone']['telefono']); ?></td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="2"><b>Falta poco para completar tu perfil</b></td>
                                </tr>
                            <?php } ?>

                            <?php if (isset($data['comprador']['nombre1']) && !isset($data['userphone']['telefono'])) { ?>
                                <tr>
                                    <td colspan="2">Solo un paso más para completar tu perfil</td>
                                </tr>
                            <?php } elseif (isset($data['comprador']['nombre1']) && isset($data['userphone']['telefono'])) { ?>
                                <tr>
                                    <td colspan="2">Tu perfil está completo, ya podés empezar a comprar.</td>
                                </tr>
                            <?php } ?>
                        </table>

                        <div class="buttons-actions">
                            <button class="button-profile" onclick="showNow(this)">Actualizar información personal</button>
                            <button class="button-profile" onclick="showPhoneForm(this)">Actualizar número de teléfono</button>
                        </div>


                        <form class="hide-form-action row g-3" id="form-personal-info" action="?action=actualizar_info" method="POST">
                            <input type="hidden" name="id_username" value="<?php echo bin2hex($usuario['email']) ?>">
                            <div class="col-12">
                                <label for="nombre1">Primer nombre</label>
                                <input class="form-control" type="text" id="nombre1" name="nombre1" placeholder="Primer nombre">
                            </div>
                            <div class="col-12">
                                <label for="nombre2">Segundo nombre</label>
                                <input class="form-control" type="text" id="nombre2" name="nombre2" placeholder="Segundo nombre">
                            </div>
                            <div class="col-12">

                                <label for="apellido1">Primer apellido</label>
                                <input class="form-control" type="text" id="apellido1" name="apellido1" placeholder="Primer apellido">
                            </div>
                            <div class="col-12">

                                <label for="apellido2">Segundo apellido</label>
                                <input class="form-control" type="text" id="apellido2" name="apellido2" placeholder="Segundo apellido">
                            </div>
                            <div class="col-12">
                                <button class="button-profile" type="button" name="submit" onclick="updateInfo(event)">Actualizar</button>

                            </div>
                        </form>

                        <?php $action = !isset($data['userphone']['telefono']) ? 'add_phone' : 'update_phone'; ?>

                        <form
                            class="hide-form-action row g-3"
                            action="?action=<?php echo $action ?>"
                            method="POST"
                            id="form-phone-user">
                            <input type="hidden" name="id_username" value="<?php echo bin2hex($usuario['email']) ?>">
                            <div class="col-12">
                                <label class="form-label" for="phone">Número de teléfono</label>
                                <input class="form-control" type="text" id="phone" name="phone" placeholder="Número de teléfono">
                            </div>
                            <div class="col-12">

                                <button class="button-profile" type="submit" name="submit" onclick="updateUserPhone(event)">Actualizar número</button>
                            </div>
                        </form>


                        <div class="container-response-mssg" id="message-resp-info">
                            <p></p>
                            <svg onclick="this.parentElement.style.display='none';" width="36px" height="36px" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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
                    <button id="accordion-button" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        <span>
                            Mis direcciones
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 72 72">
                            <circle cx="36.446" cy="28.864" r="7.225" fill="#fff" />
                            <path fill="#d22f27" d="M52.573 29.11c0-9.315-7.133-16.892-15.903-16.892s-15.903 7.577-15.903 16.896c.002.465.223 11.609 12.96 31.245a3.46 3.46 0 0 0 2.818 1.934c1.84 0 3.094-2.026 3.216-2.232C52.58 40.414 52.58 29.553 52.573 29.11M36.67 35.914a7.083 7.083 0 1 1 7.083-7.083a7.09 7.09 0 0 1-7.083 7.083" />
                            <path fill="#ea5a47" d="M52.573 29.11c0-9.315-7.133-16.892-15.903-16.892a15 15 0 0 0-3.865.525c8.395.45 15.1 7.823 15.1 16.85c.006.443.006 11.303-12.813 30.95a6 6 0 0 1-.586.797c.52.584 1.257.928 2.04.954c1.839 0 3.093-2.027 3.215-2.233C52.58 40.414 52.58 29.553 52.573 29.11" />
                            <g fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M36.545 62.294a3.46 3.46 0 0 1-2.817-1.935C20.99 40.723 20.769 29.58 20.766 29.114c0-9.32 7.134-16.896 15.904-16.896s15.903 7.577 15.903 16.892c.007.444.007 11.304-12.812 30.95c-.122.207-1.377 2.234-3.216 2.234" />
                                <path d="M36.67 35.914a7.083 7.083 0 1 1 7.083-7.083a7.09 7.09 0 0 1-7.083 7.083" />
                            </g>
                        </svg>
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushContainer">
                    <div class="accordion-body">
                        <p>Datos de envío:</p>
                        <?php if (count($data['direcciones']) > 0) {
                            $direcciones = $data['direcciones'];
                            foreach ($direcciones as $dir) {
                        ?>
                                <table>
                                    <tr>
                                        <th>Calle: </th>
                                        <td><?php echo $dir['calle_pri'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Esquina: </th>
                                        <td><?php echo $dir['calle_sec'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Número de puerta: </th>
                                        <td><?php echo $dir['num_puerta'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Número de apartamento: </th>
                                        <td><?php echo $dir['num_apartamento'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tipo de dirección: </th>
                                        <td><?php echo $dir['tipo_dir'] ?></td>
                                    </tr>
                                </table>
                                <div class="container-response" id="message-resp-direcciones2">
                                    <p></p>
                                    <svg onclick="this.parentElement.style.display='none';"
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

                                <form class="hide-form-action row g-3"
                                    id="form-direcciones_actualizar"
                                    action="?action=actualizar_direccion"
                                    method="PUT">
                                    <small>Actualizar dirección <?php echo $dir['calle_pri'] . $dir['calle_sec'] ?></small>
                                    <input type="hidden" name="id_direccion" value="<?php echo $dir['id_direccion'] ?>">
                                    <input type="hidden" name="id_username" value="<?php echo bin2hex($usuario['email']) ?>">
                                    <div class="col-md-6">
                                        <label for="calle_pri" class="form-label">Calle: </label>
                                        <input type="text" name="calle_prim" class="form-control" placeholder="Nombre de la calle" id="calle_prim">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="calle_sec" class="form-label">Esquina: </label>
                                        <input type="text" name="calle_seg" class="form-control" placeholder="Esquina" id="calle_seg">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tipo_dir" class="form-label">Tipo de dirección: </label>
                                        <select id="tipo_dir" name="tipo_dir" class="form-select">
                                            <option selected value="envio">Envío</option>
                                            <option value="facturacion">Facturación</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="num_puerta" class="form-label">Número de puerta: </label>
                                        <input class="form-control" id="num_puerta" name="num_puerta" type="text" placeholder="Número de puerta">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="num_apartamento" class="form-label">Número de apartamento: </label>
                                        <input type="text" class="form-control" name="num_apartamento" id="num_apartamento" placeholder="Número de apartamento">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ciudad" class="form-label">Ciudad: </label>
                                        <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ciudad">
                                    </div>

                                    <div class="col-12">
                                        <button type="button" onclick="updateDirecciones()" class="button-profile">Actualizar dirección</button>
                                    </div>

                                </form>

                                <div>
                                    <button data-direccion-id="<?php echo $dir['id_direccion'] ?>" onclick="showFormUpdateDir(this)" class="button-profile">Actualizar dirección</button>

                                </div>
                            <?php }
                        } else { ?>
                            <b>No tienes una dirección asociada a tu cuenta aún</b>
                            <p>Debes agregar al menos una dirección</p>
                        <?php } ?>
                        <button class="button-profile" id="add-dir-btn" onclick="showFormAddDir(this)">Agregar dirección</button>
                        <div class="container-response" id="message-resp-direcciones">
                            <p></p>
                            <svg onclick="this.parentElement.style.display='none';"
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
                        <form class="hide-form-action row g-3"
                            id="form-direcciones_agregar"
                            action="?action=actualizar_direccion"
                            method="PUT">

                            <input type="hidden" name="id_username" value="<?php echo bin2hex($usuario['email']) ?>">
                            <div class="col-md-6">
                                <label for="calle_pri" class="form-label">Calle: </label>
                                <input type="text" name="calle_prim" class="form-control" id="calle_prim" placeholder="Nombre de la calle">
                            </div>
                            <div class="col-md-6">
                                <label for="calle_sec" class="form-label">Esquina: </label>
                                <input type="text" name="calle_seg" class="form-control" id="calle_seg" placeholder="Esquina">
                            </div>
                            <div class="col-md-6">
                                <label for="tipo_dir" class="form-label">Tipo de dirección: </label>
                                <select id="tipo_dir" name="tipo_dir" class="form-select">
                                    <option selected value="envio">Envío</option>
                                    <option value="facturacion">Facturación</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="num_puerta" class="form-label">Número de puerta: </label>
                                <input class="form-control" id="num_puerta" name="num_puerta" type="text" placeholder="Número de puerta">
                            </div>
                            <div class="col-md-3">
                                <label for="num_apartamento" class="form-label">Número de apartamento: </label>
                                <input type="text" class="form-control" name="num_apartamento" id="num_apartamento" placeholder="Número de apartamento">
                            </div>
                            <div class="col-md-6">
                                <label for="ciudad" class="form-label">Ciudad: </label>
                                <input type="text" name="ciudad" class="form-control" id="ciudad" placeholder="Ciudad">
                            </div>

                            <div class="col-12">
                                <button type="button" onclick="addDirecciones()" class="button-profile">Agregar dirección</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button id="accordion-button" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <span>
                            Medios de pago
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 128 128">
                            <path fill="#ffc107" d="M116.34 101.95H11.67c-4.2 0-7.63-3.43-7.63-7.63V33.68c0-4.2 3.43-7.63 7.63-7.63h104.67c4.2 0 7.63 3.43 7.63 7.63v60.64c0 4.2-3.43 7.63-7.63 7.63" />
                            <path fill="#424242" d="M4.03 38.88h119.95v16.07H4.03z" />
                            <path fill="#fff" d="M114.2 74.14H13.87c-.98 0-1.79-.8-1.79-1.79v-8.41c0-.98.8-1.79 1.79-1.79H114.2c.98 0 1.79.8 1.79 1.79v8.41c-.01.98-.81 1.79-1.79 1.79" />
                            <path fill="none" stroke="#424242" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" d="M23.98 70.49c.56-1.08.71-2.34 1.21-3.45s1.59-2.14 2.79-1.95c1.11.18 1.8 1.29 2.21 2.33c.57 1.45.88 3 .92 4.56c.01.32-.01.67-.22.92c-.37.42-1.13.21-1.42-.27s-.22-1.09-.09-1.64c.62-2.55 2.62-4.72 5.11-5.54c.26-.09.53-.16.8-.11c.58.11.9.71 1.16 1.23c.61 1.19 1.35 2.32 2.2 3.35c.34.42.73.83 1.25.99c1.71.5 2.7-2.02 4.35-2.69c1.98-.8 3.91 1.29 6.01 1.68c3.07.57 4.7-1.82 7.39-2.43c.36-.08.75-.13 1.11-.03c.66.19 1.07.82 1.46 1.39c.91 1.34 2.21 2.66 3.83 2.67c1.03.01 1.98-.52 2.92-.97c3.33-1.59 7.26-2.25 10.74-1.03" />
                        </svg>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                    <button class="button-profile" id="add-dir-btn" onclick="showFormAddCard(this)">Agregar medio de pago</button>

                        <?php
                        if (count($data['tarjetas']) > 0) {
                            $tarjetas = $data['tarjetas'];
                            foreach ($tarjetas as $tarjeta) {
                        ?>
                                <section>
                                    <h2>Mis tarjetas</h2>
                                    <p><?php echo $tarjeta['nom_titular'] ?></p>
                                    <p><?php echo $tarjeta['nombre_tarjeta'] ?></p>
                                <button 
                                    type="button"
                                    class="button-remove-card"
                                    onclick="removeThisCard(this, event)"
                                    data-id-card="<?php echo $tarjeta['id_tarjeta']?>" 
                                    data-id-user="<?php echo bin2hex($tarjeta['email'])?>"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19px" height="19px" 
                                    viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" 
                                    d="M5.75 3V1.5h4.5V3zm-1.5 0V1a1 1 0 0 1 1-1h5.5a1 1 0 0 1 1 1v2h2.5a.75.75 0 0 1 0 1.5h-.365l-.743 9.653A2 2 0 0 1 11.148 16H4.852a2 2 0 0 1-1.994-1.847L2.115 4.5H1.75a.75.75 0 0 1 0-1.5zm-.63 1.5h8.76l-.734 9.538a.5.5 0 0 1-.498.462H4.852a.5.5 0 0 1-.498-.462z" 
                                    clip-rule="evenodd"/>
                                </svg></button>
                                </section>

                            <?php
                            }
                            
                        } else {
                            ?>
                            <p><b>No tienes ningun medio de pago asociado a tu cuenta</b></p>

                            <button class="button-profile" id="add-dir-btn" onclick="showFormAddCard(this)">Agregar medio de pago</button>
                        <?php
                        }
                        ?>
                        <form class="hide-form-action row g-3"
                            id="form-card_agregar"
                            action="?action=agregar_card"
                            method="POST">

                            <input type="hidden" name="id_username" value="<?php echo bin2hex($usuario['email']) ?>">
                            <div class="col-12">
                                <label for="nom_titular" class="form-label">Nombre del titular de la tarjeta: </label>
                                <input type="text" name="nom_titular" class="form-control" id="nom_titular" placeholder="Nombre en la tarjeta">
                            </div>
                            <div class="col-12 input-container">
                                <label for="numer" class="form-label">Número de la tarjeta: </label>
                                <input type="text" name="numero" class="form-control" id="numer" placeholder="0000 0000 0000 0000">
                                <div id="card-emitter-display" class="icon"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_ven" class="form-label">Fecha de vencimiento: </label>
                                <input type="text" name="fecha_ven" class="form-control" id="fecha_ven" placeholder="01/25">
                            </div>

                            <div class="col-12">
                                <button type="button" name="submit" onclick="addPaymentCard(this, event)" data-user-id="<?php echo bin2hex($usuario['email'])?>" class="button-profile">Agregar tarjeta</button>
                            </div>
                        </form>
                        <div class="container-response" id="message-resp-cards">
                            <p></p>
                            <svg onclick="this.parentElement.style.display='none';"
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
        </div>

    </div>

</div>


<?php

include('footer.php');
