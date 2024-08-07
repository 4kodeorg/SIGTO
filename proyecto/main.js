const menu = document.getElementById('menu-responsive')
const close = document.getElementById('close-ico')
const optionsResponsive = document.getElementById('options-responsive')
const cartItems = document.getElementById('counter')
const menuItems = document.querySelectorAll('.menu-normal-actions')
const addBtn = document.getElementById('add-btn')

function menuResponsive() {
    menu.classList.add('screen');
    optionsResponsive.classList.toggle('visible')
}
function isMenuVisible() {
    menu.classList.toggle('screen')
    optionsResponsive.classList.toggle('visible')
}

var n = 0

function addToCart() {
    n++
    cartItems.innerText = n
}

for (let i = 0; i < menuItems.length; i++) {
    menuItems[i].addEventListener('click', () => {
        if (menuItems[i].classList.contains('active')) return
        else {
            menuItems[i].classList.add('active')
            menuItems[i - 1].classList.remove('active')
            return
        }
    })
}


async function displayProds() { 
    const response = await fetch('https://dummyjson.com/products')
    if (!response.ok) {
        throw new Error("Ocurrió un error inesperado");
    }
    const prodS = await response.json();
    
    const productList = prodS.products   
    let elementsHolder = document.getElementById('product-container');
    let data = ''
    for (let product of productList) {
        data += `
               <section class='div-for-product'>
               <figure>
               <img src=${product.images[0]}
               class='img-product'
               alt=${product.category}>
               </figure>
               <figcaption><h2>${product.title}</h2></figcaption>
               <hr/>
                 <p class='product-descr'>${product.description}</p>
                 <div class='div-buy-product'>
                 <span class='span-old-price'>\$${Math.round(product.price * 1.20)}</span>
                 <span class='span-price'>\$${product.price}</span>
                 <a id='add-btn' onclick='addToCart()' class='button-action'>Agregar al carrito</a>
                 </div>
                 </section>
               `
    } elementsHolder.innerHTML = data
}
displayProds()