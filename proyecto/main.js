
async function displayProds() { 
    const response = await fetch('https://dummyjson.com/products')
    if (!response.ok) {
        throw new Error("Ocurrió un error inesperado");
    }
    const prodS = await response.json();
    
    const productList = prodS.products   
    console.log(productList);
    let elementsHolder = document.getElementById('product-container');
    let data = ''
    for (let product of productList) {
        data += `
               <section class='div-for-product'>
               <figure>
               <img src=${product.images[0]}
               alt=${product.category}>
               </figure>
               <figcaption><h2>${product.title}</h2></figcaption>
               <hr/>
                 <p>${product.description}</p>
                 <div class='div-buy-product'>
                 <span class='span-old-price'>\$${Math.round(product.price * 1.20)}</span>
                 <span class='span-price'>\$${product.price}</span>
                 <span class='span-action'>Agregar al carrito</span>
                 </div>
                 </section>
               `
    } elementsHolder.innerHTML = data
}
displayProds()