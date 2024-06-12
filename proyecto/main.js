
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
               <div class='div-for-product'>
               <figure>
               <img src=${product.images[0]}
               alt=${product.category}>
               </figure>
               <figcaption>${product.description} </figcaption>
                 <p>${product.title}</p>
                 <span>\$${product.price}</span>
                 </div>
               `
    } elementsHolder.innerHTML = data
}
displayProds()