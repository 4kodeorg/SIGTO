const menu = document.getElementById('menu-responsive')
const close = document.getElementById('close-ico')
const optionsResponsive = document.getElementById('options-responsive')

const menuItems = document.querySelectorAll('.menu-normal-actions')

function menuResponsive() {
    menu.classList.add('screen');
    optionsResponsive.classList.toggle('visible')
}
function isMenuVisible() {
    menu.classList.toggle('screen')
    optionsResponsive.classList.toggle('visible')
}

    
menuItems.forEach(item => {
    let i = 0
    item.addEventListener('click',() => {
        if (item.classList.contains('active')) { return }
        else { item.classList.add('active')
            menuItems[i].classList.remove('active')
            }
            i++
        });
    })
    


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
                 <a class='button-action'>Agregar al carrito</a>
                 </div>
                 </section>
               `
    } elementsHolder.innerHTML = data
}
displayProds()