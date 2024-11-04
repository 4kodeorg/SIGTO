const server = window.location.origin;

const menuItems = document.querySelectorAll('.menu-normal-actions')

const sections = document.querySelectorAll('.gallery-section');
const leftArrow = document.querySelector('.arrow-left');
const rightArrow = document.querySelector('.arrow-right');
const totalSections = sections.length;

const cartItem = document.getElementById('cart-item');

const cartForm = document.getElementById('form-cart-item');

const mainSearchForm = document.getElementById('search-form');

const containerDirecciones = document.getElementById('actualizar-direcciones-container');
const formInfo = document.getElementById('form-personal-info');
const formDireccionesAdd = document.getElementById('form-direcciones_agregar')
const formUpdateDireccion = document.getElementById('form-direcciones_actualizar');
const phoneForm = document.getElementById('form-phone-user');
const cardForm = document.getElementById('form-card_agregar');

const favvButtons = document.querySelectorAll('.add-to-fav-btn');

//

let currentIndex = 0;

function goLeft() { document.querySelector('.profile-section-page').style.marginLeft = '140px'; };

function getBack() { document.querySelector('.profile-section-page').style.marginLeft = 0; };

function showFormUpdateDir(el) {
    formUpdateDireccion.classList.toggle('hide-form-action');
    el.innerHTML = formUpdateDireccion.classList.contains('hide-form-action') ? 'Actualizar esta dirección' : 'Ocultar';
    
}

function showFormAddCard(el) {
    cardForm.classList.toggle('hide-form-action');
    el.innerHTML = cardForm.classList.contains('hide-form-action') ? 'Agregar medio de pago' : 'Ocultar';
}
updateSlider();
function showFormAddDir(el) {
    formDireccionesAdd.classList.toggle('hide-form-action');
    el.innerHTML = formDireccionesAdd.classList.contains('hide-form-action') ? 'Agregar dirección' : 'Ocultar';
}
spinRight();
function showNow(el) { 
    formInfo.classList.toggle('hide-form-action')
    el.innerHTML = formInfo.classList.contains('hide-form-action') ? 'Actualizar información personal' : 'Ocultar';
}
function showPhoneForm(el) {
    phoneForm.classList.toggle('hide-form-action')
    el.innerHTML = phoneForm.classList.contains('hide-form-action') ? 'Actualizar número de telefono' : 'Ocultar';
}


function showFormDir() { containerDirecciones.style.display = 'flex'; }
function hideForm() { containerDirecciones.style.display = 'none'; }


function updateSlider() {
    sections.forEach((section, index) => {
    section.style.transition = "transform 1s ease-in"
    section.style.transform = `translateX(${(index - currentIndex) * 100}%)`;

    });
}

function toRight() {
        currentIndex = (currentIndex + 1) % totalSections;
        updateSlider();
};

function toLeft() { 
        currentIndex = (currentIndex - 1 + totalSections) % totalSections;
        updateSlider();
};

function spinRight() {
    currentIndex = (currentIndex + 1) % totalSections;
    updateSlider();
    setTimeout(spinRight, 3500);
}

menuItems.forEach(link => {
    link.addEventListener('click', () => {
        menuItems.forEach(prevActive => prevActive.classList.remove('active'))
        link.classList.add('active')
    })
})
async function getFavorites(ev, el) {
    const userId = el.getAttribute('data-user-id');
    const infoSection = document.getElementById('accordionFlushContainer');
    infoSection.remove();
    const containerProducts = document.getElementById('favorites-container');
    containerProducts.insertAdjacentHTML('afterbegin', `<table class="table">
        <thead>
          <tr>
            <th colspan="5" class="fs-2">Mis favoritos</th>
            
          </tr>
        </thead>
        <tbody id="fav-products-table">
          </tbody>`)


    const tableFavoritos = document.getElementById('fav-products-table');
    try {
        const response = await fetch(`${server}/perfil/${userId}?action=get_favorites&id_user=${userId}`);
        const data = await response.json();
        if (data.success) {
            
            const favoritos = data.favoritos;
            console.log(favoritos);
            if (favoritos.length > 0) {
                favoritos.forEach(prod => {
                    tableFavoritos.insertAdjacentHTML('beforeend', renderProductFavs(prod));
                })

            } else {
                tableFavoritos.insertAdjacentHTML('beforeend', `<tr> <td colspan="5"> ${data.message} </td> </tr>`)
            }
        } else {
            containerProducts.insertAdjacentHTML('afterbegin', `<p> ${data.message} </p>`)
        }
    } catch (error) {
        
    }
}

async function getUserCompras(ev, el) {
    const userId = el.getAttribute('data-user-id');
    try {
        const response = await fetch(`${server}/perfil/${userId}?action=get_compras`)
    } catch (error) {
        
    }
}
async function removeFav(ev, el) {
    const prodId = el.getAttribute('data-product-id');
    const fullUrlRoute = window.location.href;
    const routeArray = fullUrlRoute.split('/');
    const userId = routeArray[4];
    try {
        const response = await fetch(`${server}/home?action=remove_fav`,{
            method: 'DELETE',
            headers : { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_product' : prodId
            })
        });
        const data = await response.json();
        if (data.status === 'success') {
            const currRow = el.closest('tr');
            currRow.innerHTML = `<td colspan="5">Eliminado de favoritos</td>`;
            currRow.style.cursor = 'not-allowed';
            await new Promise(resolve => setTimeout(resolve, 1500));
            currRow.remove();
        } else {
            alert(data.message);
        }

    } catch (error) {

    }
}
async function updateFavorites(ev, el) {
    ev.preventDefault();
    
    const prodId = el.getAttribute('data-product-id');
    
    const isFavorite = el.classList.contains('favoritos');
    
    const action = isFavorite ? 'remove_fav' : 'add_to_fav';
    const method = isFavorite ? 'DELETE' : 'POST';
    
    try {
        const response = await fetch(`${server}/home?action=${action}`, {
            method: method,
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_product': prodId
            })
        });

        const resultText = await response.text();
        console.log(resultText);
        const result = JSON.parse(resultText);

        if (result.status === 'success') {
            if (isFavorite) {
                el.classList.remove('favoritos');
                el.classList.add('add-to-fav-btn');
                el.setAttribute('onclick', 'updateFavorites(event, this)');
                el.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                                d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79"/></svg>`;
            } else {
                el.classList.add('favoritos');
                el.classList.remove('add-to-fav-btn');
                el.setAttribute('onclick', 'updateFavorites(event, this)');
                el.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                                d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79"/></svg>`;
            }
        } else {
            console.log(result.message);
        }

    } catch (error) {
        console.log(`Error: ${error}`);
    }
}

async function getCartData(userId) {
    try {
        const response = await fetch(`${server}/home?action=get_cart&id=${userId}`);
        return await response.json();
    } catch (error) {
        console.error("Error al obtener los datos del carrito:", error);
        return { success: false, message: "Error en la conexión." };
    }
}


async function removeFromCart(el) {
    const userId = el.getAttribute('data-user-id');
    const idProduct = el.getAttribute('data-product-id');

    try {
        const response = await fetch(`${server}/home?idUs=${userId}&action=remove_product_cart`, {
            method: 'PUT',
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_usuario': userId,
                'id_prod': idProduct
            })
        });
        const data = await response.json();
        if (data.success) {
            const itemContainer = el.closest('div');
            
            itemContainer.remove();
            alert(data.message);
            updateCartContainer(userId);
        } else {
            alert(data.message);
        }
    } catch (error) {
        
    }
    
}

async function loggInModal(e) {
    e.preventDefault();
    const formData = document.getElementById('form-modal-login');
    const logginData = new FormData(formData);
    logginData.append('submit', 'submit');
    
    try {
        const response = await fetch(`${server}/home?action=init_sess`, {
            method: 'POST',
            body: logginData
        });
        const data = await response.json();

        if (!data.success) {
            document.querySelector('.form-container-modal').insertAdjacentHTML('beforeend', renderMssg(data.mssg))
        } else {
            location.reload();
        }
    } catch (error) {
        console.error("Error", error)
    }
}
function renderMssg(mssg) {
    return `<div class='error-login'>
    <p>${mssg}</p>
    </div>`
}

async function getCarritoItems(userId) {
    const cart = document.getElementById('cart');
    const imgCart = cart.querySelector('img');
    const countItemsCart = document.getElementById('items-cart');
    const counterItems = countItemsCart.querySelector('small');
    const cartPrice = document.querySelector('.section-price-cart');
    const totalPricing = cartPrice.querySelector('b');
    let totalItems = 0;
    let totalPrice = 0;
    try {
        const data = await getCartData(userId);
        
        if (data.success) {
            const carrito = data.carrito;
            if (carrito.length === 0) {
                imgCart.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAAB6ElEQVR4nO2ZO0tcQRSAv1VBCVhrwG0Eo65CCGLjL1DE1s4gGBFlEVkQ7PILUgQCFjYW4qrrAxG1CiL2NilEsPKBibj4wELwFQZOsYTsLi5zZu4sfnCaYQ57vnvnzs5h4I3o0QucAi8F4grYBT4DMSLKSRGJf2M2qjInOUUe55lTBwwBdzLPvJnI0SMyRqK7yNwvIrJP4FQDlyLTRuDMiUiSwBkWkQyB80FELqK6e72GM5FJEDjzIjJG4IyIyCKB0yIif8rpO2khcBZeeUbTiB0bIqMREDmyIZKIgMhXGyLmI//tUeIZaMQSGY8iP7FI0qPIgE2Rdk8SN8A7myIx+VN0LTKDAiseRLo0RMYdSxxqHYs+OhaZQolYTh+vHU9AHEXWHIlso8yEI5F+bZFPDiSyQI22SIX8kKbIDxyxrizS4UokpSjxC4d0KIqkXIpUyj2KbYkHoB7HbCg0T9/xwKQUME3gdIrIAYFTJU2PWRLvCZwNeSuDlMn9yS6BU5tzrP8GtLo4I2nRB9xb3Ib3fMvYEnkEGnxfmm5KESa2ZCydJyddQo4651JA7pOMy5g58v+PbIEcs6174bZAUdcWc9RZlQK2pJi49NxmbNlijjrNebpGM9ZkMQcXmCWyJOvbhHmqxQoqJYe/S/viCgHGEU4AAAAASUVORK5CYII=";
                counterItems.innerHTML = '';
                counterItems.innerHTML = totalItems;
                totalPricing.innerHTML = '';
                totalPricing.innerHTML = totalPrice;
                return;
            } else {
            imgCart.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACTElEQVR4nO2ZzUuUQRyAn62gCDtn4F6CcjMlRLz0FxTRsdUOhqEhhkgIgbf+gg5B4MFLh8g+1JAlvRQR3b14kKBTKumSWOFBcLdi4Lfwsrwfu+v8Zt4XemAu78yPmWdm3vlg4D/p4wawCfyNSXvAJ+AOkCOlbCRI1KdnaZXZCDTyW0SZs8AIsC/lzMikjusiYySuJZQdFZFVMs5J4IfIXG4ytgi8BwoR+beA5Zh86zwXkYkmYgaAQ4nbAbpDJOPyVahNr/kGyw8BlboFYxvokvw24HtMvhoXpbJyA6vXYKCn61Ow5wshMjsuRmZLKovrtdshIxEm05Mg06Mp8kIquh+RfxeoNrgvlRNkypoyY1LJqyNKeJcpBIY+lbt8K/+Js3Vfi5dNTh+N9NGGyHgKRL7aEOlKgcgjGyI52YF9SfwBzmOJNx5FPmCRCY8iQzZFuj1J/AJO2xTJyaboWmQWBRY8iFzVEJl0LPFF61h0xbHINErkAvd47VQF8ijy1pHICso8cCRS1BbpdSCxC5zSFjkmFWmKPMURS8oifa5EphQl1nBIn6LIlEuR4/KOYlviEGjHMSWFy9MTPPBQGjBDxukXkXUyzgm59JgpcY6MU5JRGSbj3BMR8wqcac4EjvWPgUsuzkha3AQOLC7Dn33L2BKpAB2+RGqPpu+kER3yamu+zUXEzLUQo07tsSbYk3n5Zo78YezGxJhl3Qu/Yxr102KMOovSgGVpTF7u3HFP24stxKjTGXFrNN8uWIzBBWaKvJb5bZLp1aQGtRLDP753M+G6dfn9AAAAAElFTkSuQmCC";
            carrito.forEach(item => {
            totalItems += Number.parseInt(item.cantidad);
            totalPrice += Number.parseInt(item.precio_prod) * Number.parseInt(item.cantidad); 
           })
           
            counterItems.innerHTML = '';
            counterItems.innerHTML = totalItems;
            totalPricing.innerHTML = '';
            totalPricing.innerHTML = totalPrice;
             }
        } else {

        }
    } catch (error) {
        
    }
}
async function updateCartContainer(userId) {
    const itemsContainerCart = document.getElementById('offcanvas-carrito');
    itemsContainerCart.innerHTML = '';
    let totalPriceCart = 0;
    
    try {
        const data = await getCartData(userId);
        
        if (data.success) {
            const carrito = data.carrito;
            
            if (carrito.length > 0) {
                itemsContainerCart.insertAdjacentHTML('afterbegin', renderSvg());

                carrito.forEach(item => {
                    itemsContainerCart.insertAdjacentHTML('beforeend', renderCartItems(item));
                    totalPriceCart += Number.parseInt(item.precio_prod) * Number.parseInt(item.cantidad);
                });
                
                itemsContainerCart.insertAdjacentHTML('beforeend', renderButtonCheckout(carrito[0].id_usu_com));

                const totalCart = document.getElementById('total-cart-price');
                totalCart.innerHTML = `Total de compra: $ ${totalPriceCart}`;
            } else {
                itemsContainerCart.insertAdjacentHTML('afterbegin', renderAnimationEmpty(data.message));
            }
        } else {
            itemsContainerCart.insertAdjacentHTML('afterbegin', renderLoginCarrito());
        }
    } catch (error) {
        console.error("An error occurred:", error);
    }
    
    getCarritoItems(userId);
}

function closeModalLogin(elem, modal) {
    elem.style.overflow = 'unset';
    modal.style.display = 'none';
    modal.innerHTML = '';
}

async function shopNow(btn, ev) {
    ev.preventDefault();
    const userId = btn.getAttribute('data-user-id');
    await addToCart(btn);
    window.location.href = `/finalizar_compra/${userId}`;
}
async function addToCart(button, ev) {
    ev.preventDefault();
    const itemId = button.getAttribute('data-id')
    const formElement = document.getElementById(`form-cart-item-${itemId}`)
    const cartItem = new FormData(formElement);
    const mssgCarritoSuccess = document.getElementById("success-carrito-message");
    const paraphMsg = mssgCarritoSuccess.querySelector('p');
    const modalLogin = document.getElementById('container-modal-login');
    const userId = cartItem.get('id_user');

    try {
        const response = await fetch(`${server}/home?action=add_to_cart` ,{
            method: 'POST',
            body: cartItem
        })
        const dataText = await response.text();
       
        const data = JSON.parse(dataText);
        if (data.success) {
            paraphMsg.innerHTML = '';
            mssgCarritoSuccess.style.display = 'flex';
            paraphMsg.innerHTML = data.message;
        } 
            else {
            document.querySelector('body').style.overflow = 'hidden';
            modalLogin.style.display = 'block';
            modalLogin.insertAdjacentHTML('afterbegin',renderLoginModal());
        }
    } catch (error) {
        console.log(`Error: ${error}`)
    }
    updateCartContainer(userId);
    await new Promise(resolve => setTimeout(resolve, 2500));
            mssgCarritoSuccess.style.display = 'none'
            paraphMsg.innerHTML = '';
}

let currentOffset = 15; 
const limit = 5;

async function fetchMoreProducts(usId) {
    
    const spinnerLoad = document.querySelector('.loading-container');
    const sectionBelow = document.querySelector('.container-next-sect');
    const footer = document.querySelector('.footer-commerce');
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);
    
    let search = urlParams.get('buscar');
    if (search) {
        return;
    }
    spinnerLoad.classList.add('show-loader');
    footer.classList.add('hide-some');
    sectionBelow.classList.add('hide-some');
    try {
        const response = await fetch(`${server}/home?offset=${currentOffset}&limit=${limit}`);
        const productsData = await response.json();
        await new Promise(resolve => setTimeout(resolve, 1800));
        spinnerLoad.classList.remove('show-loader');
        footer.classList.remove('hide-some');
        sectionBelow.classList.remove('hide-some');
        if (productsData.productos.length > 0) {
            const tbody = document.querySelector(".container-prods table tbody");

            productsData.productos.forEach(product => {
                const isFavorite = productsData.favoritos.some(fav => fav.sku === product.sku);
                if (!document.querySelector(`#product-row-${product.sku}`)) {
                    tbody.insertAdjacentHTML('beforeend', renderProductRow(product, usId, isFavorite));
                }
            });
            currentOffset += limit;
            observeLastRow(usId);
        }
    } catch (error) {
        console.error("Error cargando los productos:", error);
    }
}

function observeLastRow(usId) {
    const rows = document.querySelectorAll(".container-prods table tbody tr");
    if (rows.length === 0) {
        return;
    }

    const lastRow = rows[rows.length - 1];

    const options = {
        root: null,
        rootMargin: '50px',
        threshold: 1 
    };

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            fetchMoreProducts(usId);
            observer.unobserve(lastRow); 
        }
    }, options);

    observer.observe(lastRow);
}

document.addEventListener("DOMContentLoaded", () => {
    if (!document.getElementById('userId')) {
        return;
    } 
    const usId = document.getElementById("userId").getAttribute('data-user-id');
    observeLastRow(usId);
    updateCartContainer(usId);
});

async function updateUserPhone(e) {
    e.preventDefault();

    const messageInfo = document.getElementById('message-resp-info');
    const formPhone = document.getElementById('form-phone-user');
    const action = formPhone.action
    const formData = new FormData(formPhone);
    const arrAction = action.split('?')
    const userId = formData.get('id_username');
    formData.append('submit', 'submit');

    try {
        const response = await fetch(`${server}/perfil/${userId}?${arrAction[1]}`,{
            method : 'POST',
            body: formData
        })
        const data = await response.json();

        if (data.success) {
            messageInfo.style.display = 'flex';
            messageInfo.querySelector('p').innerHTML = data.message;
            await new Promise(resolve => setTimeout(resolve, 1800));
            messageInfo.style.display = 'none';
            location.reload();
        } else {
            messageInfo.style.display = 'flex';
            messageInfo.querySelector('p').innerHTML = data.message;
        }

        
    } catch (error) {
        console.error(`Error: ${error}`);
    }
}

async function updateInfo() {
    const userInformation = new FormData(formInfo);
    const userId = userInformation.get('id_username');
    const APIinfouser = `${server}/perfil/${userId}?action=actualizar_info`;

    const messageInfo = document.getElementById('message-resp-info');

    userInformation.append('submit', 'submit');
    
    try {
        const respuesta = await fetch(APIinfouser, {
            method: 'POST',
            body: userInformation
        });
        const data = await respuesta.json();
        if (data.success) {
            messageInfo.style.display = 'flex';
            messageInfo.querySelector('p').innerHTML = data.message;
            
            await new Promise(resolve => setTimeout(resolve, 1800));
            location.reload();
        } else {
            messageInfo.style.display = 'flex';
            messageInfo.querySelector('p').innerHTML = data.message;
        }

    } catch(error) {
        console.log(`Error: ${error}}`)
    }
}
async function addDirecciones() {
    const messResponseDir = document.getElementById('message-resp-direcciones');
    const userData = new FormData(formDireccionesAdd);
    userData.append('submit', 'submit');
    const userId = userData.get('id_username')
    try {
        const response = await fetch (`${server}/perfil/${userId}?action=agregar_direccion`, {
            method: 'POST',
            body: userData,
        })
        const data = await response.json();
        if (data.success) {

            messResponseDir.style.display= 'flex';
            messResponseDir.querySelector('p').innerHTML = data.message;
            await new Promise(resolve => setTimeout(resolve, 1500));
            messResponseDir.style.display = 'none'
            location.reload();
        }
        else {
            messResponseDir.style.display= 'flex';
            messResponseDir.querySelector('p').innerHTML = data.message;
        }
    } catch (error) {
        console.error(`Error: ${error}`);
    }
}

async function updateDirecciones() {
    const messageResp = document.getElementById('message-resp-direcciones2')
    const actualizarDirecciones = document.getElementById('form-direcciones_actualizar');
    const userDirecciones = new FormData(actualizarDirecciones);

    userDirecciones.append('submit', 'submit');
    const userId = userDirecciones.get('id_username');
    const idDireccion = userDirecciones.get('id_direccion');
    const callePrim = userDirecciones.get('calle_prim');
    const calleSeg = userDirecciones.get('calle_seg');
    const numPuerta = userDirecciones.get('num_puerta');
    const numApto = userDirecciones.get('num_apartamento');
    const ciudad = userDirecciones.get('ciudad');
    const tipoDir = userDirecciones.get('tipo_dir');

    const APIdireccion = `${server}/perfil/${userId}?action=actualizar_direccion`;

    try {
        const respuesta = await fetch(APIdireccion, {
            method: 'PUT',
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_direccion' : idDireccion,
                'id_username' : userId,
                'calle_prim' : callePrim,
                'calle_seg' : calleSeg,
                'num_puerta' : numPuerta,
                'num_apartamento' : numApto,
                'ciudad' : ciudad,
                'tipo_dir': tipoDir,
            })
            }
        );
        const data = await respuesta.json();
        if (data.success) {
            messageResp.style.display= 'flex';
            messageResp.querySelector('p').innerHTML = data.message;
            await new Promise(resolve => setTimeout(resolve, 1500));
            messageResp.style.display = 'none';
            location.reload();
        }
        else {
            messageResp.style.display= 'flex';
            messageResp.querySelector('p').innerHTML = data.message;
        }

    }
    catch(error) {
        console.log(`Error: ${error}`);
    }
}

// PAYPAL SDK

const cartData = [];
const formsCheckoutData = document.querySelectorAll('[id^="form-product-checkout"]');

formsCheckoutData.forEach(form => {
    const formData = new FormData(form);
    const formObj = Object.fromEntries(formData.entries());

    cartData.push(formObj);
});

window.onload = function() {
    if (!document.getElementById('paypal-button-container')) {
        return; 
    }

    paypal
        .Buttons({
            style: {
                shape: "rect",
                layout: "vertical",
                color: "gold",
                label: "paypal",
            },
    
            async createOrder() {
                try {
                    const response = await fetch(`${server}/finalizar_compra/paypal/${userId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            cart: cartData
                        }),
                    });
    
                    const orderData = await response.json();
                    console.log(orderData);
    
                    if (orderData.id) {
                        return orderData.id;  
                    } else {
                        throw new Error("Order ID is missing from the response.");
                    }
                } catch (error) {
                    console.error(error);
                }
            } ,
    
            async onApprove(data, actions) {
                try {
                    const response = await fetch(
                        `${server}/finalizar_compra/paypal/?pyid=${data.orderID}&action=capture`,
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                        }
                    );
    
                    const orderData = await response.json();
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you message
    
                    const errorDetail = orderData?.details?.[0];
    
                    if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                        // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                        // recoverable state, per
                        // https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
                        return actions.restart();
                    } else if (errorDetail) {
                        // (2) Other non-recoverable errors -> Show a failure message
                        throw new Error(
                            `${errorDetail.description} (${orderData.debug_id})`
                        );
                    } else if (!orderData.purchase_units) {
                        throw new Error(JSON.stringify(orderData));
                    } else {
                        // (3) Successful transaction -> Show confirmation or thank you message
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        const transaction =
                            orderData?.purchase_units?.[0]?.payments
                                ?.captures?.[0] ||
                            orderData?.purchase_units?.[0]?.payments
                                ?.authorizations?.[0];
                        resultMessage(
                            `Transaction ${transaction.status}: ${transaction.id}<br>
              <br>See console for all available details`
                        );
                        console.log(
                            "Capture result",
                            orderData,
                            JSON.stringify(orderData, null, 2)
                        );
                    }
                } catch (error) {
                    console.error(error);
                    resultMessage(
                        `Sorry, your transaction could not be processed...<br><br>${error}`
                    );
                }
            } ,
        })
        .render("#paypal-button-container"); 
}

function renderCartItems(item, cantidad) {
    return `<div class="item-container-cart"> 
        <h4>${item.titulo}</h4>
        <p>Cantidad: ${item.cantidad}</p>
        <b>Precio: $ ${item.precio_prod}</b>
        <button 
        data-product-id='${item.sku_prod}'
        data-user-id='${item.id_usu_com}'
        onclick='removeFromCart(this)'>Eliminar del carrito
        <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m7.5 5.5l-3.447 5.29a1.64 1.64 0 0 0-.043 1.723L7.5 18.5h11.36a1.64 1.64 0 0 0 1.64-1.641V7.14a1.64 1.64 0 0 0-1.64-1.641zm2.5 3l7 7m-7 0l6.93-7"/>
        </svg></button>
    
        </div>`
}

function renderLoginCarrito() {
    return `<div class="empty-cart-container"><p>Tienes que iniciar sesión para seguir comprando</p> 
            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="180.84799" height="290.07702" 
            viewBox="0 0 744.84799 747.07702" xmlns:xlink="http://www.w3.org/1999/xlink"><path id="fa3b9e12-7275-481e-bee9-64fd9595a50d-73" 
            data-name="Path 1" d="M299.205,705.80851l-6.56-25.872a335.96693,335.96693,0,0,0-35.643-12.788l-.828,12.024-3.358-13.247c-15.021-4.29394-25.24-6.183-25.24-6.183s13.8,52.489,42.754,92.617l33.734,5.926-26.207,3.779a135.92592,135.92592,0,0,0,11.719,12.422c42.115,39.092,89.024,57.028,104.773,40.06s-5.625-62.412-47.74-101.5c-13.056-12.119-29.457-21.844-45.875-29.5Z" 
            transform="translate(-227.576 -76.46149)" fill="#f2f2f2"/><path id="bde08021-c30f-4979-a9d8-cb90b72b5ca2-74" data-name="Path 2" 
            d="M361.591,677.70647l7.758-25.538a335.93951,335.93951,0,0,0-23.9-29.371l-6.924,9.865,3.972-13.076c-10.641-11.436-18.412-18.335-18.412-18.335s-15.315,52.067-11.275,101.384l25.815,22.51-24.392-10.312a135.91879,135.91879,0,0,0,3.614,16.694c15.846,55.234,46.731,94.835,68.983,88.451s27.446-56.335,11.6-111.569c-4.912-17.123-13.926-33.926-24.023-48.965Z" 
            transform="translate(-227.576 -76.46149)" fill="#f2f2f2"/><path id="b3ac2088-de9b-4f7f-bc99-0ed9705c1a9d-75" data-name="Path 22" d="M747.327,253.4445h-4.092v-112.1a64.883,64.883,0,0,0-64.883-64.883H440.845a64.883,64.883,0,0,0-64.883,64.883v615a64.883,64.883,0,0,0,64.883,64.883H678.352a64.883,64.883,0,0,0,64.882-64.883v-423.105h4.092Z" 
            transform="translate(-227.576 -76.46149)" fill="#e6e6e6"/><path id="b2715b96-3117-487c-acc0-20904544b5b7-76" data-name="Path 23" d="M680.97,93.3355h-31a23.02,23.02,0,0,1-21.316,31.714H492.589a23.02,23.02,0,0,1-21.314-31.714H442.319a48.454,48.454,0,0,0-48.454,48.454v614.107a48.454,48.454,0,0,0,48.454,48.454H680.97a48.454,48.454,0,0,0,48.454-48.454h0V141.7885a48.454,48.454,0,0,0-48.454-48.453Z" 
            transform="translate(-227.576 -76.46149)" fill="#fff"/><path id="b06d66ec-6c84-45dd-8c27-1263a6253192-77" data-name="Path 6" d="M531.234,337.96451a24.437,24.437,0,0,1,12.23-21.174,24.45,24.45,0,1,0,0,42.345A24.43391,24.43391,0,0,1,531.234,337.96451Z" 
            transform="translate(-227.576 -76.46149)" fill="#ccc"/><path id="e73810fe-4cf4-40cc-8c7c-ca544ce30bd4-78" data-name="Path 7" d="M561.971,337.96451a24.43594,24.43594,0,0,1,12.23-21.174,24.45,24.45,0,1,0,0,42.345A24.43391,24.43391,0,0,1,561.971,337.96451Z" transform="translate(-227.576 -76.46149)" 
            fill="#ccc"/><circle id="a4813fcf-056e-4514-bb8b-e6506f49341f" data-name="Ellipse 1" cx="364.43401" cy="261.50202" r="24.45" fill="#41b953"/><path id="bbe451c3-febc-41ba-8083-4c8307a2e73e-79" data-name="Path 8" d="M632.872,414.3305h-142.5a5.123,5.123,0,0,1-5.117-5.117v-142.5a5.123,5.123,0,0,1,5.117-5.117h142.5a5.123,5.123,0,0,1,5.117,5.117v142.5A5.123,5.123,0,0,1,632.872,414.3305Zm-142.5-150.686a3.073,3.073,0,0,0-3.07,3.07v142.5a3.073,3.073,0,0,0,3.07,3.07h142.5a3.073,3.073,0,0,0,3.07-3.07v-142.5a3.073,3.073,0,0,0-3.07-3.07Z" 
            transform="translate(-227.576 -76.46149)" fill="#ccc"/><rect id="bb28937d-932f-4fdf-befe-f406e51091fe" data-name="Rectangle 1" x="218.56201" y="447.10197" width="218.552" height="2.047" fill="#ccc"/>
            <circle id="fcef55fc-4968-45b2-93bb-1a1080c85fc7" data-name="Ellipse 2" cx="225.46401" cy="427.41999" r="6.902" fill="#41b953"/><rect id="ff33d889-4c74-4b91-85ef-b4882cc8fe76" data-name="Rectangle 2" x="218.56201" y="516.11803" width="218.552" height="2.047" fill="#ccc"/><circle id="e8fa0310-b872-4adf-aedd-0c6eda09f3b8" 
            data-name="Ellipse 3" cx="225.46401" cy="496.43702" r="6.902" fill="#41b953"/><path d="M660.69043,671.17188H591.62207a4.50493,4.50493,0,0,1-4.5-4.5v-24.208a4.50492,4.50492,0,0,1,4.5-4.5h69.06836a4.50491,4.50491,0,0,1,4.5,4.5v24.208A4.50492,4.50492,0,0,1,660.69043,671.17188Z" transform="translate(-227.576 -76.46149)" fill="#41b953"/><circle id="e12ee00d-aa4a-4413-a013-11d20b7f97f7" 
            data-name="Ellipse 7" cx="247.97799" cy="427.41999" r="6.902" fill="#41b953"/><circle id="f58f497e-6949-45c8-be5f-eee2aa0f6586" data-name="Ellipse 8" cx="270.492" cy="427.41999" r="6.902" fill="#41b953"/><circle id="b4d4939a-c6e6-4f4d-ba6c-e8b05485017d" data-name="Ellipse 9" cx="247.97799" cy="496.43702" r="6.902" fill="#41b953"/><circle id="aff120b1-519b-4e96-ac87-836aa55663de" data-name="Ellipse 10" cx="270.492" cy="496.43702" r="6.902" fill="#41b953"/>
            <path id="f1094013-1297-477a-ac57-08eac07c4bd5-80" data-name="Path 88" d="M969.642,823.53851H251.656c-1.537,0-2.782-.546-2.782-1.218s1.245-1.219,2.782-1.219H969.642c1.536,0,2.782.546,2.782,1.219S971.178,823.53851,969.642,823.53851Z" transform="translate(-227.576 -76.46149)" fill="#3f3d56"/><path d="M792.25256,565.92292a10.09371,10.09371,0,0,1,1.41075.78731l44.8523-19.14319,1.60093-11.81526,17.92157-.10956-1.05873,27.0982-59.19987,15.65584a10.60791,10.60791,0,0,1-.44749,1.20835,10.2346,10.2346,0,1,1-5.07946-13.68169Z" 
            transform="translate(-227.576 -76.46149)" fill="#ffb8b8"/><polygon points="636.98 735.021 624.72 735.021 618.888 687.733 636.982 687.734 636.98 735.021" fill="#ffb8b8"/><path d="M615.96281,731.51778h23.64387a0,0,0,0,1,0,0v14.88687a0,0,0,0,1,0,0H601.076a0,0,0,0,1,0,0v0A14.88686,14.88686,0,0,1,615.96281,731.51778Z" fill="#2f2e41"/><polygon points="684.66 731.557 672.459 732.759 662.018 686.271 680.025 684.497 684.66 731.557" 
            fill="#ffb8b8"/><path d="M891.68576,806.12757h23.64387a0,0,0,0,1,0,0v14.88687a0,0,0,0,1,0,0H876.7989a0,0,0,0,1,0,0v0A14.88686,14.88686,0,0,1,891.68576,806.12757Z" transform="translate(-303.00873 15.2906) rotate(-5.62529)" fill="#2f2e41"/><circle cx="640.3925" cy="384.57375" r="24.56103" fill="#ffb8b8"/><path d="M849.55636,801.91945a4.47086,4.47086,0,0,1-4.415-3.69726c-6.34571-35.22559-27.08789-150.40528-27.584-153.59571a1.42684,1.42684,0,0,1-.01562-.22168v-8.58789a1.489,1.489,0,0,1,.27929-.87207l2.74024-3.83789a1.47845,1.47845,0,0,1,1.14355-.625c15.62207-.73242,66.78418-2.8789,69.25586.209h0c2.48242,3.10351,1.60547,12.50683,1.4043,14.36035l.00977.19336,22.98535,146.99512a4.51238,4.51238,0,0,1-3.71485,5.13476l-14.35644,2.36524a4.52127,4.52127,0,0,1-5.02539-3.09278c-4.44043-14.18847-19.3291-61.918-24.48926-80.38672a.49922.49922,0,0,0-.98047.13868c.25781,17.60546.88086,62.52343,1.0957,78.0371l.02344,1.6709a4.51811,4.51811,0,0,1-4.09277,4.53614l-13.84375,1.25781C849.83565,801.91359,849.695,801.91945,849.55636,801.91945Z" transform="translate(-227.576 -76.46149)" fill="#2f2e41"/>
            <path id="ae7af94f-88d7-4204-9f07-e3651de85c05-81" data-name="Path 99" d="M852.38089,495.2538c-4.28634,2.548-6.85116,7.23043-8.32276,11.9951a113.681,113.681,0,0,0-4.88444,27.15943l-1.55553,27.60021-19.25508,73.1699c16.68871,14.1207,26.31542,10.91153,48.78049-.63879s25.03222,3.85117,25.03222,3.85117l4.49236-62.25839,6.41837-68.03232a30.16418,30.16418,0,0,0-4.86143-4.67415,49.65848,49.65848,0,0,0-42.44229-8.99538Z" transform="translate(-227.576 -76.46149)" fill="#41b953"/><path d="M846.12661,580.70047a10.52561,10.52561,0,0,1,1.50061.70389l44.34832-22.1972.736-12.02551,18.2938-1.26127.98041,27.4126L852.7199,592.93235a10.4958,10.4958,0,1,1-6.59329-12.23188Z" transform="translate(-227.576 -76.46149)" fill="#ffb8b8"/><path id="a6768b0e-63d0-4b31-8462-9b2e0b00f0fd-82" data-name="Path 101" d="M902.76552,508.41151c10.91151,3.85117,12.83354,45.57369,12.83354,45.57369-12.8367-7.06036-28.24139,4.49318-28.24139,4.49318s-3.20916-10.91154-7.06034-25.03223a24.52987,24.52987,0,0,1,5.13436-23.10625S891.854,504.558,902.76552,508.41151Z" transform="translate(-227.576 -76.46149)" fill="#41b953"/><path id="bfd7963f-0cf8-4885-9d3a-2c00bccda2e3-83" 
            data-name="Path 102" d="M889.99122,467.53052c-3.06-2.44837-7.23517,2.00173-7.23517,2.00173l-2.4484-22.03349s-15.30095,1.8329-25.0935-.61161-11.32255,8.87513-11.32255,8.87513a78.57978,78.57978,0,0,1-.30582-13.77092c.61158-5.50838,8.56838-11.01675,22.6451-14.68932S887.6518,439.543,887.6518,439.543C897.44542,444.43877,893.05121,469.97891,889.99122,467.53052Z" transform="translate(-227.576 -76.46149)" fill="#2f2e41"/>
            </svg>
            <a class="complete-transa-btn" href="/cuenta"> Iniciar sesión</a>
            </div>`
}

function renderProductRow(product, usId, isFavorite) {
    return `
    <div class="individual-card">
        <a href='/product/${product.sku}'><b>${product.nombre}</b>
       
        <p>${product.descripcion}</p>
        <p>${product.precio}</p>
        
        <section>
            <form id='form-cart-item-${product.sku}' method='POST' action='?action=add_to_cart'>
                <input class='product-quant' type='number' name='quantity' value='1'>
                <input type='hidden' name='id_product' value='${product.sku}'>
                <input type='hidden' name='id_user' value='${usId}'>
                <input type='hidden' name='id_vendedor' value='${product.id_usu_ven}'>
                <input type='hidden' name='titulo' value='${product.nombre}'>
                <input type='hidden' name='price' value='${product.precio}'>
                <button class='cart-btn' type='button' data-id='${product.sku}' onclick='addToCart(this)'>
                   <svg class='cart' fill='currentColor' viewBox='0 0 576 512' height='25px' width='25px' xmlns='http://www.w3.org/2000/svg'><path d='M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z'></path></svg>
                <svg xmlns='http://www.w3.org/2000/svg' height='20px' width='20px' viewBox='0 0 640 512' class='product'><path d='M211.8 0c7.8 0 14.3 5.7 16.7 13.2C240.8 51.9 277.1 80 320 80s79.2-28.1 91.5-66.8C413.9 5.7 420.4 0 428.2 0h12.6c22.5 0 44.2 7.9 61.5 22.3L628.5 127.4c6.6 5.5 10.7 13.5 11.4 22.1s-2.1 17.1-7.8 23.6l-56 64c-11.4 13.1-31.2 14.6-44.6 3.5L480 197.7V448c0 35.3-28.7 64-64 64H224c-35.3 0-64-28.7-64-64V197.7l-51.5 42.9c-13.3 11.1-33.1 9.6-44.6-3.5l-56-64c-5.7-6.5-8.5-15-7.8-23.6s4.8-16.6 11.4-22.1L137.7 22.3C155 7.9 176.7 0 199.2 0h12.6z'>
                </path></svg>
                </button>
            </form>
            <button class='add-to-fav-btn ${isFavorite ? "favoritos" : ""}' 
                    onclick='updateFavorites(event, this)' 
                    data-product-id='${product.sku}'>
                <svg xmlns='http://www.w3.org/2000/svg' width='28px' height='28px' viewBox='0 0 24 24'>
                    <path fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1' d='M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79'/>
                </svg> 
            </button>
            </section>
        </a>
    </div>`;
}

function renderLoginModal() {
    return `<section class="form-container-modal"> 
               <span class="close-modal-span">
                <svg
                class="close-modal-login"
                onclick="closeModalLogin(document.body, this.parentElement.parentElement.parentElement)"
                xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" 
                viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" 
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16M4.22 4.22a.75.75 0 0 1 1.06 0L8 6.94l2.72-2.72a.75.75 0 1 1 1.06 1.06L9.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L8 9.06l-2.72 2.72a.75.75 0 0 1-1.06-1.06L6.94 8L4.22 5.28a.75.75 0 0 1 0-1.06" clip-rule="evenodd"/>
                </svg> </span>
            <form method="POST"
                    id="form-modal-login" 
                    class='login-home-modalform'
                    action="?action=init_sess">
            <label for='username'>Usuario </label>
            <input name='username' type='text' id='username' placeholder='Ingrese su usuario' required>
            <label for='password'>Contraseña </label>
            <input name='passwd' type='password' id='password' placeholder='Ingrese su contraseña' required>
            <button onclick="loggInModal(event)" type="button" name="submit"> Iniciar sesion </button>
            <a class="button-modal-login" href="">
        Continuar con google <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="38px" height="38px" viewBox="0 0 48 48">
          <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
          <path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
          <path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
          <path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
        </svg>
      </a>
      <a class="button-modal-login" href="/registro">No tienes cuenta?</a>
            </form>
            
            </section>`
}

function renderButtonCheckout(comprador) {
    return `<div> <p id="total-cart-price"></p>
                <a class="complete-transa-btn" href="/finalizar_compra/${comprador}">Finalizar compra
                <svg xmlns="http://www.w3.org/2000/svg" aria-labelledby="title" width="32px" height="32px" viewBox="0 0 24 24">
                <title>Cerrar</title
                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M21 15h-2.5a1.503 1.503 0 0 0-1.5 1.5a1.503 1.503 0 0 0 1.5 1.5h1a1.503 1.503 0 0 1 1.5 1.5a1.503 1.503 0 0 1-1.5 1.5H17m2 0v1m0-8v1m-6 6H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h2m12 3.12V9a2 2 0 0 0-2-2h-2" />
                <path d="M16 10V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v6m8 0H8m8 0h1m-9 0H7m1 4v.01M8 17v.01m4-3.02V14m0 3v.01" />
                </g>
                </svg>
                </a>
                <button>Vaciar carrito
                <svg xmlns="http://www.w3.org/2000/svg" width="22px" height="22px" viewBox="0 0 32 32"><circle cx="10" cy="28" r="2" fill="currentColor"/><circle cx="24" cy="28" r="2" fill="currentColor"/><path fill="currentColor" d="M4.98 2.804A1 1 0 0 0 4 2H0v2h3.18l3.84 19.196A1 1 0 0 0 8 24h18v-2H8.82l-.8-4H26a1 1 0 0 0 .976-.783L29.244 7h-2.047l-1.999 9H7.62Z"/><path fill="currentColor" d="M18.41 8L22 4.41L20.59 3L17 6.59L13.41 3L12 4.41L15.59 8L12 11.59L13.41 13L17 9.41L20.59 13L22 11.59z"/>
                </svg></button></div>`
}

function renderSvg () {
    return `<svg class="svg-carrito-bg" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="320" height="700.04834" viewBox="0 0 888 741.04834" xmlns:xlink="http://www.w3.org/1999/xlink">
        <path d="M521.89611,253.85607H517.8642v-110.453a63.92718,63.92718,0,0,0-63.92738-63.92726H219.92738A63.92718,63.92718,0,0,0,156,143.40309V749.35675A63.92719,63.92719,0,0,0,219.92738,813.284H453.93682a63.92719,63.92719,0,0,0,63.92738-63.92726V332.47837h4.03191Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M456.51633,96.10749h-30.546a22.68123,22.68123,0,0,1-20.99971,31.24733H270.90951a22.68123,22.68123,0,0,1-20.99972-31.24733h-28.53a47.74011,47.74011,0,0,0-47.74018,47.74005V748.91223a47.74012,47.74012,0,0,0,47.74018,47.74012H456.51633a47.74012,47.74012,0,0,0,47.74018-47.74012V143.84754A47.74011,47.74011,0,0,0,456.51633,96.10749Z" transform="translate(-156 -79.47583)" fill="#fff" />
        <path d="M269.67241,219.11054H255.63313a1.86134,1.86134,0,0,0-1.86133,1.86133v6.16225a1.86134,1.86134,0,0,0,1.86133,1.86133h2.32651v9.23317h9.38625v-9.23317h2.32652a1.86133,1.86133,0,0,0,1.86132-1.86133v-6.16225A1.86133,1.86133,0,0,0,269.67241,219.11054Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M283.73425,275.50749a72.178,72.178,0,0,1-12.55683-42.79357,1.52226,1.52226,0,0,0-1.18821-1.5191v-2.66269H255.16187v2.62568h-.2043a1.52142,1.52142,0,0,0-1.51944,1.52339q.00006.05544.00418.11074,1.75218,24.42494-11.83339,43.8076a4.19288,4.19288,0,0,0-.75883,2.541l1.62129,50.15132a4.34147,4.34147,0,0,0,4.30433,4.19019h33.53723a4.343,4.343,0,0,0,4.30692-4.26409l.62478-48.69283A8.78784,8.78784,0,0,0,283.73425,275.50749Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M278.42523,292.16618H249.23369a2.997,2.997,0,0,0-2.96218,3.45275l4.41126,28.67321h25.33006l5.3581-28.5766a2.997,2.997,0,0,0-2.9457-3.54936Z" transform="translate(-156 -79.47583)" fill="#fff" />
        <path d="M425.95669,369.34511H411.91741a1.86133,1.86133,0,0,0-1.86133,1.86132v6.16226a1.86134,1.86134,0,0,0,1.86133,1.86133h2.32651v9.23316h9.38625V379.23h2.32652a1.86133,1.86133,0,0,0,1.86132-1.86133v-6.16226A1.86132,1.86132,0,0,0,425.95669,369.34511Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M440.01853,425.74206a72.178,72.178,0,0,1-12.55683-42.79357,1.52226,1.52226,0,0,0-1.1882-1.5191V378.7667H411.44615v2.62568h-.2043a1.52141,1.52141,0,0,0-1.51944,1.52339q.00007.05542.00418.11074,1.75218,24.42492-11.83339,43.8076a4.19294,4.19294,0,0,0-.75883,2.541l1.62129,50.15132a4.34145,4.34145,0,0,0,4.30433,4.19018h33.53723a4.343,4.343,0,0,0,4.30692-4.26409l.62479-48.69283A8.78789,8.78789,0,0,0,440.01853,425.74206Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M434.70951,442.40074H405.518a2.997,2.997,0,0,0-2.96218,3.45276l4.41126,28.6732h25.33006l5.35811-28.57659a2.9971,2.9971,0,0,0-2.94571-3.54937Z" transform="translate(-156 -79.47583)" fill="#fff" />
        <path d="M249.935,581.73267h-6.65947a.88292.88292,0,0,0-.88292.88291v2.923a.88292.88292,0,0,0,.88292.88291h1.10357v4.37972h4.45233v-4.37972H249.935a.88291.88291,0,0,0,.88291-.88291v-2.923A.88291.88291,0,0,0,249.935,581.73267Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M256.60519,608.48432a34.2373,34.2373,0,0,1-5.95627-20.29895.72208.72208,0,0,0-.56363-.72057v-1.263H243.052v1.24548h-.09691a.72168.72168,0,0,0-.72074.72262q0,.02628.002.05252a31.24565,31.24565,0,0,1-5.61312,20.77995,1.98884,1.98884,0,0,0-.35994,1.20529l.769,23.78907a2.05934,2.05934,0,0,0,2.04174,1.98759h15.90824a2.06007,2.06007,0,0,0,2.043-2.02265l.29636-23.09723A4.1684,4.1684,0,0,0,256.60519,608.48432Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <rect x="83.13662" y="537.75318" width="15.17906" height="7.58953" fill="#fff" />
        <path d="M280.935,581.73267h-6.65947a.88292.88292,0,0,0-.88292.88291v2.923a.88292.88292,0,0,0,.88292.88291h1.10357v4.37972h4.45233v-4.37972H280.935a.88291.88291,0,0,0,.88291-.88291v-2.923A.88291.88291,0,0,0,280.935,581.73267Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M287.60519,608.48432a34.2373,34.2373,0,0,1-5.95627-20.29895.72208.72208,0,0,0-.56363-.72057v-1.263H274.052v1.24548h-.09691a.72168.72168,0,0,0-.72074.72262q0,.02628.002.05252a31.24565,31.24565,0,0,1-5.61312,20.77995,1.98884,1.98884,0,0,0-.35994,1.20529l.769,23.78907a2.05934,2.05934,0,0,0,2.04174,1.98759h15.90824a2.06007,2.06007,0,0,0,2.043-2.02265l.29636-23.09723A4.1684,4.1684,0,0,0,287.60519,608.48432Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <rect x="114.13662" y="537.75318" width="15.17906" height="7.58953" fill="#fff" />
        <path d="M311.935,581.73267h-6.65947a.88292.88292,0,0,0-.88292.88291v2.923a.88292.88292,0,0,0,.88292.88291h1.10357v4.37972h4.45233v-4.37972H311.935a.88291.88291,0,0,0,.88291-.88291v-2.923A.88291.88291,0,0,0,311.935,581.73267Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M318.60519,608.48432a34.2373,34.2373,0,0,1-5.95627-20.29895.72208.72208,0,0,0-.56363-.72057v-1.263H305.052v1.24548h-.09691a.72168.72168,0,0,0-.72074.72262q0,.02628.002.05252a31.24565,31.24565,0,0,1-5.61312,20.77995,1.98884,1.98884,0,0,0-.35994,1.20529l.769,23.78907a2.05934,2.05934,0,0,0,2.04174,1.98759h15.90824a2.06007,2.06007,0,0,0,2.043-2.02265l.29636-23.09723A4.1684,4.1684,0,0,0,318.60519,608.48432Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <rect x="145.13662" y="537.75318" width="15.17906" height="7.58953" fill="#fff" />
        <path d="M401.56726,523.61282H387.528a1.86132,1.86132,0,0,0-1.86133,1.86132v6.16226a1.86133,1.86133,0,0,0,1.86133,1.86133h2.32651v9.23316h9.38625v-9.23316h2.32651a1.86133,1.86133,0,0,0,1.86132-1.86133v-6.16226A1.86132,1.86132,0,0,0,401.56726,523.61282Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M415.6291,580.00977a72.178,72.178,0,0,1-12.55683-42.79357,1.52226,1.52226,0,0,0-1.1882-1.5191v-2.66269H387.05672v2.62568h-.2043a1.52141,1.52141,0,0,0-1.51944,1.52339q.00007.05542.00418.11074,1.75218,24.42492-11.83339,43.8076a4.19294,4.19294,0,0,0-.75883,2.541l1.62129,50.15132a4.34145,4.34145,0,0,0,4.30434,4.19018h33.53722a4.343,4.343,0,0,0,4.30693-4.26409l.62478-48.69283A8.78782,8.78782,0,0,0,415.6291,580.00977Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M410.32009,596.66845H381.12854a2.997,2.997,0,0,0-2.96218,3.45276l4.41127,28.6732h25.33006l5.3581-28.57659a2.9971,2.9971,0,0,0-2.9457-3.54937Z" transform="translate(-156 -79.47583)" fill="#fff" />
        <path d="M409.23171,339.93829H325.544c5.85094-31.63336,4.50485-69.83172,0-110.91142h83.68771C404.84668,270.1067,403.53635,308.305,409.23171,339.93829Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <circle cx="211.892" cy="201.98189" r="20.16571" fill="#fff" />
        <path d="M332.602,487.148H248.91429c5.85093-31.63337,4.50485-69.83173,0-110.91143H332.602C328.217,417.31641,326.90664,455.5147,332.602,487.148Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <circle cx="135.26229" cy="349.1916" r="20.16571" fill="#fff" />
        <path d="M456.62114,346.99629H372.93343c5.85093-31.63336,4.50485-69.83172,0-110.91142h83.68771C452.2361,277.1647,450.92578,315.363,456.62114,346.99629Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <circle cx="259.28142" cy="209.03989" r="20.16571" fill="#fff" />
        <path d="M456.62114,341.95487H372.93343c5.85093-31.63337,4.50485-69.83173,0-110.91143h83.68771C452.2361,272.12327,450.92578,310.32156,456.62114,341.95487Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <circle cx="259.28142" cy="203.99847" r="20.16571" fill="#fff" />
        <path d="M456.62114,346.99629H372.93343c5.85093-31.63336,4.50485-69.83172,0-110.91142h83.68771C452.2361,277.1647,450.92578,315.363,456.62114,346.99629Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <circle cx="259.28142" cy="209.03989" r="20.16571" fill="#fff" />
        <rect x="45.52486" y="254.41275" width="274.25371" height="30.24857" fill="#e6e6e6" />
        <rect x="45.52486" y="404.64732" width="274.25371" height="30.24857" fill="#e6e6e6" />
        <rect x="45.52486" y="554.88188" width="274.25371" height="30.24857" fill="#e6e6e6" />
        <path d="M952.85457,757.07471l-68.32479-48.32553c23.04357-22.44766,44.00226-54.41107,64.04589-90.55092l68.32478,48.32553C989.59882,697.53027,966.4714,727.95969,952.85457,757.07471Z" transform="translate(-156 -79.47583)" fill="#41b953" />
        <circle cx="796.87342" cy="605.9822" r="20.16571" fill="#fff" />
        <path d="M623.26239,536.554h-7.5a.99435.99435,0,0,0-.99435.99435v3.292a.99434.99434,0,0,0,.99435.99434h1.24285v4.93249h5.01427v-4.93249h1.24285a.99435.99435,0,0,0,.99435-.99434v-3.292A.99436.99436,0,0,0,623.26239,536.554Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M630.77443,566.68205a38.55843,38.55843,0,0,1-6.708-22.86093.81323.81323,0,0,0-.63476-.81152v-1.42245h-7.921v1.40268h-.10914a.81275.81275,0,0,0-.8117.81381q0,.02961.00223.05916a35.18922,35.18922,0,0,1-6.32157,23.40264,2.23989,2.23989,0,0,0-.40537,1.35741l.86611,26.79155a2.31928,2.31928,0,0,0,2.29944,2.23846h17.91606a2.32008,2.32008,0,0,0,2.30082-2.27794l.33376-26.0124A4.69456,4.69456,0,0,0,630.77443,566.68205Z" transform="translate(-156 -79.47583)" fill="#41b953" />
        <path d="M621.69892,537.62665a2.14526,2.14526,0,0,1-4.29053,0" transform="translate(-156 -79.47583)" opacity="0.2" style="isolation:isolate" />
        <rect x="456.16063" y="492.36817" width="15.12429" height="10.08286" fill="#fff" />
        <path d="M860.60239,641.21767H846.56312a1.86134,1.86134,0,0,0-1.86134,1.86133v6.16226a1.86134,1.86134,0,0,0,1.86134,1.86132h2.32651v9.23317h9.38625v-9.23317h2.32651a1.86132,1.86132,0,0,0,1.86132-1.86132V643.079A1.86133,1.86133,0,0,0,860.60239,641.21767Z" transform="translate(-156 -79.47583)" fill="#e6e6e6" />
        <path d="M874.66423,697.61463a72.178,72.178,0,0,1-12.55683-42.79358,1.52224,1.52224,0,0,0-1.1882-1.51909v-2.6627H846.09185v2.62568h-.2043a1.52142,1.52142,0,0,0-1.51944,1.5234q.00008.05543.00418.11073,1.75218,24.42493-11.83339,43.80761a4.19289,4.19289,0,0,0-.75883,2.54095l1.62129,50.15132a4.34146,4.34146,0,0,0,4.30434,4.19019h33.53722a4.343,4.343,0,0,0,4.30692-4.26409l.62479-48.69283A8.7878,8.7878,0,0,0,874.66423,697.61463Z"
          transform="translate(-156 -79.47583)" fill="#41b953" />
        <path d="M857.67571,643.22557a4.01574,4.01574,0,0,1-8.03148,0"
          transform="translate(-156 -79.47583)" opacity="0.2" style="isolation:isolate" />
        <path d="M869.35522,714.27331H840.16367a2.997,2.997,0,0,0-2.96218,3.45275l4.41126,28.67321h25.33007l5.3581-28.5766a2.9971,2.9971,0,0,0-2.9457-3.54936Z" transform="translate(-156 -79.47583)" fill="#fff" />
        <path d="M820.546,756.99571H736.85827c5.85094-31.63336,4.50486-69.83172,0-110.91142H820.546C816.161,687.16411,814.85062,725.36241,820.546,756.99571Z" transform="translate(-156 -79.47583)" fill="#41b953" />
        <circle cx="623.20627" cy="619.03931" r="20.16571" fill="#fff" />
        <polygon points="322.243 328.466 341.03 326.758 352.986 297.724 331.637 285.768 322.243 328.466" fill="#ffb8b8" />
        <path d="M650.66043,487.64986v0a10.59328,10.59328,0,0,0-9.20188-14.51664l-29.16988-1.73941-4.2949,14.28206,30.02882,8.24691A10.59326,10.59326,0,0,0,650.66043,487.64986Z" transform="translate(-156 -79.47583)" fill="#ffb8b8" />
        <path d="M619.33866,494.16267l-.32093-26.79954-64.79286-10.33856L504.30953,399.777a16.33816,16.33816,0,0,0-21.29428-2.91186l0,0a16.33815,16.33815,0,0,0-2.84636,24.922l41.17966,50.67767Z" transform="translate(-156 -79.47583)" fill="#575a89" />
        <path d="M463.72552,795.64251h17.07932L523.168,604.10914l43.88737,59.16871,25.619,128.09483h16.22535l-3.41586-137.48845-57.2157-146.88208H491.90639c-15.40224,27.87449-27.48462,56.60826-13.66345,86.25052Z" transform="translate(-156 -79.47583)" fill="#2f2e41" />
        <path d="M582.20449,807.27611a4.45733,4.45733,0,0,0,3.4756,5.71828l41.79324,7.41672a6.87646,6.87646,0,0,0,7.8008-4.71314h0a6.83384,6.83384,0,0,0-3.34222-8.12572,63.9022,63.9022,0,0,1-23.04833-20.0382c-4.59335,4.27726-9.7273,3.875-15.179.72281l-5.78247.72281Z" transform="translate(-156 -79.47583)" fill="#2f2e41" />
        <path d="M455.81759,807.27611a4.45733,4.45733,0,0,0,3.4756,5.71828l41.79324,7.41672a6.87646,6.87646,0,0,0,7.8008-4.71314h0a6.83384,6.83384,0,0,0-3.34222-8.12572,63.9022,63.9022,0,0,1-23.04833-20.0382c-4.59335,4.27726-9.7273,3.875-15.179.72281l-5.78247.72281Z" transform="translate(-156 -79.47583)" fill="#2f2e41" />
        <circle cx="353.41268" cy="284.48709" r="23.91104" fill="#ffb8b8" />
        <path d="M488.06354,513.40689,550.403,511.699l-18.30772-57.61963c11.37738-18.23924-.073-36.46-16.27789-54.67684l-12.80948-8.53965-20.49517-1.70793h0a50.3141,50.3141,0,0,0-13.54915,35.0504C469.36939,452.03191,474.29652,482.324,488.06354,513.40689Z" transform="translate(-156 -79.47583)" fill="#575a89" />
        <path d="M631.29146,552.19152h0a10.59327,10.59327,0,0,0-2.74926-16.96611L602.4085,522.15112l-9.567,11.441,24.36342,19.395A10.59327,10.59327,0,0,0,631.29146,552.19152Z" transform="translate(-156 -79.47583)" fill="#ffb8b8" />
        <path d="M599.933,545.85758l10.24759-24.765-55.50168-34.99377-23.37023-72.268a16.33817,16.33817,0,0,0-18.43188-11.054h0a16.33815,16.33815,0,0,0-12.42089,21.79283l17.92341,62.79126Z" transform="translate(-156 -79.47583)" fill="#575a89" />
        <path d="M470.13027,354.5693c0,9.30389,6.04222,23.7124,13.66345,29.8888,5.12781,4.15568,11.90457,3.98066,14.51741-1.70793,2.68032-5.83557,11.91945-19.55229,28.18086-28.18087,21.67761-11.50252-7.68756-31.18152-28.18086-28.18086C482.9115,328.64329,470.13027,339.00544,470.13027,354.5693Z" transform="translate(-156 -79.47583)" fill="#2f2e41" />
        <circle cx="328.64768" cy="245.20468" r="17.07931" fill="#2f2e41" />
        <path d="M504.28889,318.70275a17.06865,17.06865,0,0,0-15.79836-17.01463c.42437-.03158.84854-.06468,1.28094-.06468a17.07931,17.07931,0,0,1,0,34.15862c-.4324,0-.85657-.0331-1.28094-.06468A17.06869,17.06869,0,0,0,504.28889,318.70275Z" transform="translate(-156 -79.47583)" fill="#2f2e41" />
        <ellipse cx="353.83966" cy="287.90296" rx="3.84284" ry="5.12379" fill="#ffb8b8" />
        <polygon points="837.751 684.845 571.879 684.845 515.578 418.694 467.529 418.694 467.529 406.752 525.258 406.752 581.559 672.902 837.751 672.902 837.751 684.845" fill="#3f3d56" />
        <circle cx="610.84102" cy="707.87676" r="25.59138" fill="#3f3d56" />
        <circle cx="801.92331" cy="707.87676" r="25.59138" fill="#3f3d56" />
        <path d="M988.90348,758.69673H730.22506L684.58373,533.14489h347.15138a12.2655,12.2655,0,0,1,12.11592,14.16689l-42.8333,201.0251A12.20374,12.20374,0,0,1,988.90348,758.69673Zm-255.86937-3.41219H988.90348a8.80568,8.80568,0,0,0,8.74205-7.47748l42.8333-201.0251a8.85014,8.85014,0,0,0-8.74372-10.22489H688.72567Z" transform="translate(-156 -79.47583)" fill="#3f3d56" />
        <polygon points="624.513 678.499 594.623 455.653 597.989 455.097 627.879 677.943 624.513 678.499" fill="#3f3d56" />
        <polygon points="790.712 676.788 787.343 676.242 816.36 455.102 819.729 455.648 790.712 676.788" fill="#3f3d56" />
        <rect x="708.11491" y="455.37515" width="3.41218" height="222.84575" fill="#3f3d56" />
        <rect x="865.45079" y="431.52231" width="3.41219" height="330.29569" transform="translate(112.38887 1382.90398) rotate(-89.86127)" fill="#3f3d56" />
        <rect x="718.83766" y="700.96181" width="290.1779" height="3.41226" transform="translate(-160.7831 -73.5538) rotate(-0.39166)" fill="#3f3d56" />
        <ellipse cx="472.64757" cy="411.01676" rx="18.76701" ry="10.23655" fill="#3f3d56" />
      </svg>`
}

function renderAnimationEmpty(message) {
    return `<div class="empty-cart-container">
            <p>${message}</p>
            <section>
        <div class="animation-container">
        <div class="bounce"></div>
        <div class="pebble1"></div>
        <div class="pebble2"></div>
        <div class="pebble3"></div>
      </div>
        </section>
                <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" width="120" height="200" 
    viewBox="0 0 896 747.97143" xmlns:xlink="http://www.w3.org/1999/xlink">
    <title>Carrito vacio</title>
    <path d="M193.634,788.75225c12.42842,23.049,38.806,32.9435,38.806,32.9435s6.22712-27.47543-6.2013-50.52448-38.806-32.9435-38.806-32.9435S181.20559,765.7032,193.634,788.75225Z" 
    transform="translate(-152 -76.01429)" fill="#2f2e41"/><path d="M202.17653,781.16927c22.43841,13.49969,31.08016,40.3138,31.08016,40.3138s-27.73812,4.92679-50.17653-8.57291S152,772.59636,152,772.59636,179.73811,767.66958,202.17653,781.16927Z" 
    transform="translate(-152 -76.01429)" fill="#41b953"/><rect x="413.2485" y="35.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="513.2485" y="37.40779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="452.2485" y="37.40779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="484.2485" y="131.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="522.2485" y="113.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="583.2485" y="113.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="670.2485" y="176.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="708.2485" y="158.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="769.2485" y="158.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="656.2485" y="640.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="694.2485" y="622.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="755.2485" y="622.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="417.2485" y="319.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="455.2485" y="301.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="516.2485" y="301.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="461.2485" y="560.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="499.2485" y="542.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="560.2485" y="542.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="685.2485" y="487.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="723.2485" y="469.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <rect x="784.2485" y="469.90779" width="2" height="18.5" fill="#f2f2f2"/>
    <polygon points="362.06 702.184 125.274 702.184 125.274 700.481 360.356 700.481 360.356 617.861 145.18 617.861 134.727 596.084 136.263 595.347 146.252 616.157 362.06 616.157 362.06 702.184" 
    fill="#2f2e41"/><circle cx="156.78851" cy="726.03301" r="17.88673" fill="#3f3d56"/>
    <circle cx="333.10053" cy="726.03301" r="17.88673" fill="#3f3d56"/><circle cx="540.92726" cy="346.153" r="11.07274" fill="#3f3d56"/>
    <path d="M539.38538,665.76747H273.23673L215.64844,477.531H598.69256l-.34852,1.10753Zm-264.8885-1.7035H538.136l58.23417-184.82951H217.95082Z" 
    transform="translate(-152 -76.01429)" fill="#2f2e41"/><polygon points="366.61 579.958 132.842 579.958 82.26 413.015 418.701 413.015 418.395 413.998 366.61 579.958" 
    fill="#f2f2f2"/><polygon points="451.465 384.7 449.818 384.263 461.059 341.894 526.448 341.894 526.448 343.598 462.37 343.598 451.465 384.7" 
    fill="#2f2e41"/><rect x="82.2584" y="458.58385" width="345.2931" height="1.7035" fill="#2f2e41"/><rect x="101.45894" y="521.34377" width="306.31852" height="1.7035" 
    fill="#2f2e41"/><rect x="254.31376" y="402.36843" width="1.7035" height="186.53301" fill="#2f2e41"/><rect x="385.55745" y="570.79732" width="186.92877" height="1.70379" 
    transform="translate(-274.73922 936.23495) rotate(-86.24919)" fill="#2f2e41"/><rect x="334.45728" y="478.18483" width="1.70379" height="186.92877" 
    transform="translate(-188.46866 -52.99638) rotate(-3.729)" fill="#2f2e41"/><rect y="745" width="896" height="2" 
    fill="#2f2e41"/><path d="M747.41068,137.89028s14.61842,41.60627,5.62246,48.00724S783.39448,244.573,783.39448,244.573l47.22874-12.80193-25.86336-43.73993s-3.37348-43.73992-3.37348-50.14089S747.41068,137.89028,747.41068,137.89028Z" 
    transform="translate(-152 -76.01429)" fill="#a0616a"/><path d="M747.41068,137.89028s14.61842,41.60627,5.62246,48.00724S783.39448,244.573,783.39448,244.573l47.22874-12.80193-25.86336-43.73993s-3.37348-43.73992-3.37348-50.14089S747.41068,137.89028,747.41068,137.89028Z" transform="translate(-152 -76.01429)" opacity="0.1"/><path d="M722.87364,434.46832s-4.26731,53.34138,0,81.07889,10.66828,104.5491,10.66828,104.5491,0,145.08854,23.4702,147.22219,40.53945,4.26731,42.6731-4.26731-10.66827-12.80193-4.26731-17.06924,8.53462-19.20289,0-36.27213,0-189.8953,0-189.8953l40.53945,108.81641s4.26731,89.61351,8.53462,102.41544-4.26731,36.27213,10.66827,38.40579,32.00483-10.66828,40.53945-14.93559-12.80193-4.26731-8.53462-6.401,17.06924-8.53462,12.80193-10.66828-8.53462-104.54909-8.53462-104.54909S879.69728,414.1986,864.7617,405.664s-24.537,6.16576-24.537,6.16576Z" 
    transform="translate(-152 -76.01429)" fill="#2f2e41"/><path d="M761.27943,758.78388v17.06924s-19.20289,46.39942,0,46.39942,34.13848,4.8083,34.13848-1.59266V763.05119Z" transform="translate(-152 -76.01429)" fill="#2f2e41"/><path d="M887.16508,758.75358v17.06924s19.20289,46.39941,0,46.39941-34.13848,4.80831-34.13848-1.59266V763.02089Z" transform="translate(-152 -76.01429)" fill="#2f2e41"/><circle cx="625.28185" cy="54.4082" r="38.40579" fill="#a0616a"/><path d="M765.54674,201.89993s10.66828,32.00482,27.73752,25.60386l17.06924-6.401L840.22467,425.9337s-23.47021,34.13848-57.60869,12.80193S765.54674,201.89993,765.54674,201.89993Z" 
    transform="translate(-152 -76.01429)" fill="#41b953"/><path d="M795.41791,195.499l9.60145-20.26972s56.54186,26.67069,65.07648,35.20531,8.53462,21.33655,8.53462,21.33655l-14.93559,53.34137s4.26731,117.351,4.26731,121.61834,14.93559,27.73751,4.26731,19.20289-12.80193-17.06924-21.33655-4.26731-27.73751,27.73752-27.73751,27.73752Z" 
    transform="translate(-152 -76.01429)" fill="#3f3d56"/><path d="M870.09584,349.12212l-6.401,59.74234s-38.40579,34.13848-29.87117,36.27214,12.80193-6.401,12.80193-6.401,14.93559,14.93559,23.47021,6.401S899.967,355.52309,899.967,355.52309Z" transform="translate(-152 -76.01429)" fill="#a0616a"/><path d="M778.1,76.14416c-8.51412-.30437-17.62549-.45493-24.80406,4.13321a36.31263,36.31263,0,0,0-8.5723,8.39153c-6.99153,8.83846-13.03253,19.95926-10.43553,30.92537l3.01633-1.1764a19.75086,19.75086,0,0,1-1.90515,8.46261c.42475-1.2351,1.84722.76151,1.4664,2.01085L733.543,139.792c5.46207-2.00239,12.25661,2.05189,13.08819,7.80969.37974-12.66123,1.6932-27.17965,11.964-34.59331,5.17951-3.73868,11.73465-4.88,18.04162-5.8935,5.81832-.935,11.91781-1.82659,17.49077.08886s10.31871,7.615,9.0553,13.37093c2.56964-.88518,5.44356.90566,6.71347,3.30856s1.33662,5.2375,1.37484,7.95506c2.73911,1.93583,5.85632-1.9082,6.97263-5.07112,2.62033-7.42434,4.94941-15.32739,3.53783-23.073s-7.72325-15.14773-15.59638-15.174a5.46676,5.46676,0,0,0,1.42176-3.84874l-6.48928-.5483a7.1723,7.1723,0,0,0,4.28575-2.25954C802.7981,84.73052,782.31323,76.29477,778.1,76.14416Z" transform="translate(-152 -76.01429)" fill="#2f2e41"/>
    <path d="M776.215,189.098s-17.36929-17.02085-23.62023-15.97822S737.80923,189.098,737.80923,189.098s-51.20772,17.06924-49.07407,34.13848S714.339,323.51826,714.339,323.51826s19.2029,100.28179,2.13366,110.95006,81.07889,38.40579,83.21254,25.60386,6.401-140.82123,0-160.02412S776.215,189.098,776.215,189.098Z" transform="translate(-152 -76.01429)" fill="#3f3d56"/><path d="M850.89294,223.23648h26.38265S895.6997,304.31537,897.83335,312.85s6.401,49.07406,4.26731,49.07406-44.80675-8.53462-44.80675-2.13365Z" transform="translate(-152 -76.01429)" fill="#3f3d56"/><path d="M850,424.01429H749c-9.85608-45.34-10.67957-89.14649,0-131H850C833.70081,334.115,832.68225,377.62137,850,424.01429Z" transform="translate(-152 -76.01429)" fill="#f2f2f2"/><path d="M707.93806,368.325,737.80923,381.127s57.60868,8.53462,57.60868-14.93559-57.60868-10.66827-57.60868-10.66827L718.60505,349.383Z" transform="translate(-152 -76.01429)" fill="#a0616a"/><path d="M714.339,210.43455l-25.60386,6.401L669.53227,329.91923s-6.401,29.87117,4.26731,32.00482S714.339,381.127,714.339,381.127s4.26731-32.00483,12.80193-32.00483L705.8044,332.05288,718.60633,257.375Z" transform="translate(-152 -76.01429)" fill="#3f3d56"/><rect x="60.2485" y="352.90779" width="140" height="2" fill="#f2f2f2"/><rect x="98.2485" y="334.90779" width="2" height="18.5" fill="#f2f2f2"/><rect x="159.2485" y="334.90779" width="2" height="18.5" fill="#f2f2f2"/><rect x="109.2485" y="56.90779" width="140" height="2" fill="#f2f2f2"/>
    <rect x="209.2485" y="58.40779" width="2" height="18.5" fill="#f2f2f2"/><rect x="148.2485" y="58.40779" width="2" height="18.5" fill="#f2f2f2"/><rect x="250.2485" y="253.90779" width="140" height="2" fill="#f2f2f2"/><rect x="350.2485" y="255.40779" width="2" height="18.5" fill="#f2f2f2"/><rect x="289.2485" y="255.40779" width="2" height="18.5" fill="#f2f2f2"/><rect x="12.2485" y="252.90779" width="140" height="2" fill="#f2f2f2"/><rect x="112.2485" y="254.40779" width="2" height="18.5" fill="#f2f2f2"/><rect x="51.2485" y="254.40779" width="2" height="18.5" fill="#f2f2f2"/><rect x="180.2485" y="152.90779" width="140" height="2" fill="#f2f2f2"/><rect x="218.2485" y="134.90779" width="2" height="18.5" fill="#f2f2f2"/><rect x="279.2485" y="134.90779" width="2" height="18.5" fill="#f2f2f2"/>
    </svg>
        
    </div>`
}


function renderProductFavs(product) {
    return `<tr>
   <td>
    <img src="..." class="card-img-top" alt="..."></td>
   <td> 
    <h5 class="card-title">${product.nombre}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">${product.descripcion}</h6></td>
    <td><h5 class="card-title"><b>${product.estado} </b></h5> 
    <h6 class="card-subtitle mb-2 text-body-secondary">Precio $: ${product.precio}</h6>
    </p></td>
    <td>
    <button data-product-id="${product.sku}" class="button-profile" type="button" onclick="removeFav(event, this)">Eliminar de favoritos
    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 1216 1312"><path fill="currentColor" d="M1202 1066q0 40-28 68l-136 136q-28 28-68 28t-68-28L608 976l-294 294q-28 28-68 28t-68-28L42 1134q-28-28-28-68t28-68l294-294L42 410q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294l294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68L880 704l294 294q28 28 28 68"/>
    </svg>
    </button>
    </td>
</tr>`
}