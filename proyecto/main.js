const menu = document.getElementById('menu-responsive')
const close = document.getElementById('close-ico')
const optionsResponsive = document.getElementById('options-responsive')
const cartItems = document.getElementById('counter')
const menuItems = document.querySelectorAll('.menu-normal-actions')
const addBtn = document.getElementById('add-btn')

const sections = document.querySelectorAll('.gallery-section');
const leftArrow = document.querySelector('.arrow-left');
const rightArrow = document.querySelector('.arrow-right');
const totalSections = sections.length;

const cartItem = document.getElementById('cart-item');

const cartForm = document.getElementById('form-cart-item');

const mainSearchForm = document.getElementById('search-form');
const actDirecciones = document.getElementById('form-direcciones');
const containerDirecciones = document.getElementById('actualizar-direcciones-container');

const containerInfo = document.getElementById('actualizar-info');
const formPersonalInfo = document.getElementById('form-personal-info');

//

let currentIndex = 0;

function goLeft() { document.querySelector('.profile-section-page').style.marginLeft = '140px'; };

function getBack() { document.querySelector('.profile-section-page').style.marginLeft = 0; };

updateSlider();

spinRight();
function showNow() { containerInfo.style.display = 'flex'; }
function hideNow() { containerInfo.style.display = 'none'; }

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

function menuResponsive() {
    menu.classList.add('screen');
    optionsResponsive.classList.toggle('visible')
}
function isMenuVisible() {
    menu.classList.toggle('screen')
    optionsResponsive.classList.toggle('visible')
}

menuItems.forEach(link => {
    link.addEventListener('click', () => {
        menuItems.forEach(prevActive => prevActive.classList.remove('active'))
        link.classList.add('active')
    })
})

const inputSearch = document.getElementById('busqueda');
async function liveSearchRes(e) {

}
const favvButtons = document.querySelectorAll('.add-to-fav-btn');

// favvButtons.forEach(button => {
//     button.addEventListener('click', addToFav)
//     console.log()
// })

async function updateFavorites(ev, el) {
    ev.preventDefault();
    
    const prodId = el.getAttribute('data-product-id');
    const userId = el.getAttribute('data-user-id');
    
    const isFavorite = el.classList.contains('favoritos');
    
    const action = isFavorite ? 'remove_fav' : 'add_to_fav';
    const method = isFavorite ? 'DELETE' : 'POST';
    
    try {
        const response = await fetch(`http://localhost/home?action=${action}`, {
            method: method,
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_user': userId,
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
async function openCart() {
    const userId = document.getElementById('userId');
    const actualId = userId.getAttribute('data-user-id');
    const carritoContainer = document.getElementById('offcanvas-carrito');

    try {
        const response = await fetch(`http://localhost/home?action=open_cart&userId=${actualId}`,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        });
        const data = await response.json();
        if (data.success) {
            data.carrito.forEach(item => {
                carritoContainer.insertAdjacentElement('beforeend', `<p>${item.titulo}</p>`);
            });
            
        } else {

        }
    } catch (error) {
        console.log(`Error: ${error}`);
    }
}

const itemsCart = document.getElementById('items-cart');
const cart = document.getElementById('cart');
const cartCounter = itemsCart.querySelector('small');
const priceContainer = cart.querySelector('b');

async function getCarritoItems(userId) {
    try {
        const response = await fetch (`http://localhost/home?action=get_cart&id=${userId}`)
        const data = await response.json();

        if (data.success) {
            
        } else {

        }
    } catch (error) {
        
    }
}

async function updateCart(button) {
    const itemId = button.getAttribute('data-id')
    
    const formElement = document.getElementById(`form-cart-item-${itemId}`)
    const cartItem = new FormData(formElement);
    const cart = document.getElementById('cart');
    const imgCart = cart.querySelector('img');
    console.log(`User: ${cartItem.get('id_user')}`);
    console.log(`Item ${itemId}`);
    let itemsQuantity = Number.parseInt(cartItem.get('quantity'));
    let itemPrice = Number.parseInt(cartItem.get('price'));
    
    console.log(`Cantidad: ${itemsQuantity}, \n
                Precio: ${itemPrice}\n
                Id: ${itemId}`);
    try {
        const response = await fetch('http://localhost/home?action=add_to_cart' ,{
            method: 'POST',
            body: cartItem
        })
        const dataText = await response.text();
       
        const data = JSON.parse(dataText);
        if (data.success) {
            imgCart.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACTElEQVR4nO2ZzUuUQRyAn62gCDtn4F6CcjMlRLz0FxTRsdUOhqEhhkgIgbf+gg5B4MFLh8g+1JAlvRQR3b14kKBTKumSWOFBcLdi4Lfwsrwfu+v8Zt4XemAu78yPmWdm3vlg4D/p4wawCfyNSXvAJ+AOkCOlbCRI1KdnaZXZCDTyW0SZs8AIsC/lzMikjusiYySuJZQdFZFVMs5J4IfIXG4ytgi8BwoR+beA5Zh86zwXkYkmYgaAQ4nbAbpDJOPyVahNr/kGyw8BlboFYxvokvw24HtMvhoXpbJyA6vXYKCn61Ow5wshMjsuRmZLKovrtdshIxEm05Mg06Mp8kIquh+RfxeoNrgvlRNkypoyY1LJqyNKeJcpBIY+lbt8K/+Js3Vfi5dNTh+N9NGGyHgKRL7aEOlKgcgjGyI52YF9SfwBzmOJNx5FPmCRCY8iQzZFuj1J/AJO2xTJyaboWmQWBRY8iFzVEJl0LPFF61h0xbHINErkAvd47VQF8ijy1pHICso8cCRS1BbpdSCxC5zSFjkmFWmKPMURS8oifa5EphQl1nBIn6LIlEuR4/KOYlviEGjHMSWFy9MTPPBQGjBDxukXkXUyzgm59JgpcY6MU5JRGSbj3BMR8wqcac4EjvWPgUsuzkha3AQOLC7Dn33L2BKpAB2+RGqPpu+kER3yamu+zUXEzLUQo07tsSbYk3n5Zo78YezGxJhl3Qu/Yxr102KMOovSgGVpTF7u3HFP24stxKjTGXFrNN8uWIzBBWaKvJb5bZLp1aQGtRLDP753M+G6dfn9AAAAAElFTkSuQmCC";
            let currentQuant = Number.parseInt(cartCounter.innerHTML);
            cartCounter.innerHTML = itemsQuantity + currentQuant;
            let currTotal = Number.parseInt(priceContainer.innerHTML);
            let totalNow = (itemPrice * itemsQuantity) + currTotal;
            priceContainer.innerHTML = totalNow;
        } 
            else {
            alert(data.message);
        }
    } catch (error) {
        console.log(`Error: ${error}`)
    }
}

async function updateInfo() {
    const messageInfo = document.getElementById('message-resp-info');
    const userInformation = new FormData(formPersonalInfo);
    const userId = userInformation.get('idusername');
    const APIinfouser = `http://localhost/perfil/${userId}?action=actualizar_info`;

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
            setTimeout(() => {
                location.reload();
            }, 2000)
        } else {

            messageInfo.style.display = 'flex';
            messageInfo.querySelector('p').innerHTML = data.message;
        }

    } catch(error) {
        console.log(`Error: ${error}}`)
    }
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
        const response = await fetch(`http://localhost/home?offset=${currentOffset}&limit=${limit}`);
        const productsData = await response.json();
        await new Promise(resolve => setTimeout(resolve, 1800));
        spinnerLoad.classList.remove('show-loader');
        footer.classList.remove('hide-some');
        sectionBelow.classList.remove('hide-some');
        if (productsData.productos.length > 0) {
            const tbody = document.querySelector(".container-prods table tbody");

            productsData.productos.forEach(product => {
                const isFavorite = productsData.favoritos.some(fav => fav.id_prod === product.id);
                if (!document.querySelector(`#product-row-${product.id}`)) {
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

function renderProductRow(product, usId, isFavorite) {
    return `
    <tr>
        <th><a href='/product/${product.id}'>${product.titulo}</a></th>
        <td>${product.id}</td>
        <td>${product.descripcion}</td>
        <td>${product.precio}</td>
        
        <td>
            <form id='form-cart-item-${product.id}' method='POST' action='?action=add_to_cart'>
                <input class='product-quant' type='number' name='quantity' value='1'>
                <input type='hidden' name='id_product' value='${product.id}'>
                <input type='hidden' name='id_user' value='${usId}'>
                <input type='hidden' name='titulo' value='${product.titulo}'>
                <input type='hidden' name='price' value='${product.precio}'>
                <button type='button' data-id='${product.id}' onclick='updateCart(this)'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='28px' height='28px' viewBox='0 0 24 24'>
                        <path fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1' d='M10.5 10h4m-2-2v4m4 9a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m-8 0a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3M3.71 5.4h15.214c1.378 0 2.373 1.27 1.995 2.548l-1.654 5.6C19.01 14.408 18.196 15 17.27 15H8.112c-.927 0-1.742-.593-1.996-1.452zm0 0L3 3'/>
                    </svg> 
                </button>
            </form>
            <button class='add-to-fav-btn ${isFavorite ? "favoritos" : ""}' 
                    onclick='updateFavorites(event, this)' 
                    data-product-id='${product.id}' 
                    data-user-id='${usId}'>
                <svg xmlns='http://www.w3.org/2000/svg' width='28px' height='28px' viewBox='0 0 24 24'>
                    <path fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1' d='M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79'/>
                </svg> 
            </button>
        </td>
    </tr>`;
}


function observeLastRow(usId) {
    const rows = document.querySelectorAll(".container-prods table tbody tr");
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
const usId = document.getElementById("userId").getAttribute('data-user-id');

document.addEventListener("DOMContentLoaded", () => {
    observeLastRow(usId);
});


async function updateDirecciones() {
    const messageResponse = document.getElementById('message-resp-direcciones');
    const userDirecciones = new FormData(actDirecciones);

    userDirecciones.append('submit', 'submit');
    const userId = userDirecciones.get('idusername');
    const APIdireccion = `http://localhost/perfil/${userId}?action=actualizar_direccion`;

    try {
        const respuesta = await fetch(APIdireccion, {
            method: 'POST',
            body: userDirecciones
        }
        );
        const dataRespuesta = await respuesta.json();
        if (dataRespuesta.success) {
            messageResponse.style.display= 'flex';
            messageResponse.querySelector('p').innerHTML = dataRespuesta.message
            setTimeout(() => {
                location.reload();
            }, 2000)
        }
        else {
            messageResponse.style.display= 'flex';
            messageResponse.querySelector('p').innerHTML = dataRespuesta.message
        }

    }
    catch(error) {
        console.log(`Error: ${error}`);
    }

}

// AGREGAR Y REMOVER FAVORITOS --PREE

async function addToFav(ev, el) {
    ev.preventDefault();
    const productId = el.getAttribute('data-product-id');
    const userId = el.getAttribute('data-user-id');
    console.log(productId, userId);
    
    try {
        const response = await fetch('http://localhost/home?action=add_to_fav', {
            method: 'POST',
            headers: {  'Content-type': 'application/x-www-form-urlencoded'  },
            body: new URLSearchParams({
                'id_user': userId,
                'id_product': productId
        })
        });
        const resultText = await response.text();
        console.log(resultText);
        const result = JSON.parse(resultText);

        if (result.status === 'success') {
            el.classList.add('favoritos');
        } else {
            console.log(result.message);
        }

    } catch (error) {
        console.log(`Error: ${error}`)
    }
}
async function removeFav(ev, el) {
    ev.preventDefault();
    const prodId = el.getAttribute('data-product-id');
    const userId = el.getAttribute('data-user-id');

    try {
        const response = await fetch ('http://localhost/home?action=remove_fav', {
            method: 'DELETE',
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_user': userId,
                'id_product': prodId
            })
        });
        const resultText = await response.text();
        console.log(resultText);
        const result = JSON.parse(resultText);
        if (result.status === 'success') {
            el.classList.remove('favoritos');
            el.classList.add('add-to-fav-btn');
            el.setAttribute('onclick', 'addToFav(event, this)');
            el.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7.75 3.5C5.127 3.5 3 5.76 3 8.547C3 14.125 12 20.5 12 20.5s9-6.375 9-11.953C21 5.094 18.873 3.5 16.25 3.5c-1.86 0-3.47 1.136-4.25 2.79c-.78-1.654-2.39-2.79-4.25-2.79"/></svg>`;
      
        } else {
            console.log(result.message);
        }
    }
    catch (error) {
        console.log(`Error: ${error}`)
    }
}

