const linksBackoff = document.querySelectorAll('.nav-option');
const formProducts = document.getElementById('add_product_form');
const msgContainer = document.getElementById('sub-product');


async function productsForm() {
    
    productsData = new FormData(formProducts);
    productsData.append('submit', 'submit');
    try {
    const response = await fetch("http://localhost/admin/productos?action=agregar_producto",
         {
    method: 'POST',
    body: productsData
    })
    const data = await response.json() 
    msgContainer.style.display = 'flex';
    const msgParrafo = msgContainer.querySelector('p')
    if (msgParrafo) {
        msgParrafo.innerHTML = data.mssg; 
    }
    if (data.success) {
        formProducts.reset();
    }
    
}
    catch(err) {
        msgContainer.style.display = 'flex';
        const msgParrafo = msgContainer.querySelector('p')
    if (msgParrafo) {
        msgParrafo.innerHTML = `Error: ${err}`;
    }
}
};