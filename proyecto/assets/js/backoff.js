const linksBackoff = document.querySelectorAll('.nav-option');
const formProducts = document.getElementById('add_product_form');
const msgContainer = document.getElementById('sub-product');

async function showEditForm(buttonElement) {
    const productId = buttonElement.dataset.productId;

    try {
        const response = await fetch(`http://localhost/admin/productos/${productId}`);
        
        const data = await response.json();
        if (data.success) {
            const product = data.product;
            document.getElementById("edit_product_id").value = productId;
            document.getElementById("new_titulo").value = product.titulo;
            document.getElementById("new_descripcion").value = product.descripcion;
            document.getElementById("new_origen").value = product.origen;
            document.getElementById("new_cantidad").value = product.cantidad;
            document.getElementById("new_precio").value = product.precio;
    
            document.getElementById("edit_product_modal").style.display = "block";
        }

    } catch (error) {
        console.error('Error :', error);
    }
}

function closeEditForm() {
    document.getElementById("edit_product_modal").style.display = "none";
}
const productsContainer = document.getElementById('row-of-products');
const headerContainer = document.querySelector('.report-header');
const tableHeader = document.querySelector('.table-headers');
const btnLoadProds = document.getElementById('btn-load-prods');

function reloadPage() {
    location.reload();
}
async function getDisabledProds() {
    
    try {
        const response = await fetch('http://localhost/admin/productos?action=get_disabled_products');
        btnLoadProds.remove();
        const productos = await response.json();
        
        console.log(productos.disabledprods);
        if (productos.success) {

            headerContainer.innerHTML = '';
            headerContainer.innerHTML = `<h4>Artículos desactivados</h4><button onclick="reloadPage()" class="products-btn"> Volver a mis productos
            <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24"><path fill="currentColor" d="M11.92 19.92L4 12l7.92-7.92l1.41 1.42l-5.5 5.5H22v2H7.83l5.51 5.5zM4 12V2H2v20h2z"/></svg>                            
            </button>`
            tableHeader.innerHTML = '';
            tableHeader.innerHTML = `<th scope="col">ID</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Origen</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Activar</th> `;
            productsContainer.innerHTML = '';
            productos.disabledprods.forEach(prod => {
                productsContainer.insertAdjacentHTML('beforeend', renderProducts(prod));
            });
        } else {

        }
    }
    catch (error) {
        console.log(`Error ${error}`)
    }

}
function renderProducts (product) {
   return `<tr>
        <th>${product.id}</th>
        <td>${product.titulo}</td>
        <td>${product.origen}</td>
        <td>${product.precio}</td>
        <td>Desactivado</td>
        <td>
        <button class="button-product-actions" data-product-id="${product.id}" onclick="activateProduct(event, this)"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24">
        <path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5"/>
        </svg>
        </button>
        </td>
        </tr>`;
    
}
async function activateProduct(ev, el) {
    const productId = el.getAttribute('data-product-id');
    try {
        const response = await fetch("http://localhost/admin/productos?action=activate_product", {
            method: 'PUT',
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_product': productId
            })

        })
        const data = await response.json();
        if (data.status) {
            const currRow = el.closest('tr');
            currRow.innerHTML = '';
            currRow.innerHTML = `<th class="success-msg" colspan="6">${data.message}</th>`;
            await new Promise(resolve => setTimeout(resolve, 2000));
            currRow.remove();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.log(`Error: ${error}`)
    }
}

async function submitEditForm(e) {
    e.preventDefault(); 

    const formData = new FormData(document.getElementById("edit_product_form"));
    
    try {
        const response = await fetch("http://localhost/admin/productos?action=edit_producto", {
            method: 'POST',
            body: formData
        });
        const text = await response.text()
        console.log(text);
        const data = JSON.parse(text);

        if (data.success) {
            alert(data.message);
            closeEditForm();
            location.reload(); 
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.log(`Error: ${error}`)
        console.error('Error submitting form:', error);
    }
}
let currentPage = 1;
const productsPerPage = 15;

async function loadMoreProducts(el) {
    currentPage++;
    const wrapper = document.querySelector('.wrapper');
    
    wrapper.style.display = 'block';
    el.style.display = 'none';
    try {
        const response = await fetch(`/admin/productos?action=get_productos&offset=${(currentPage - 1) * productsPerPage}&limit=${productsPerPage}`);
        const products = await response.json();
       
        await new Promise(resolve => setTimeout(resolve, 2000));

        wrapper.style.display = 'none';
        el.style.display = 'inline-block';
      
        if (products.length > 0) {
            const tbody = document.querySelector("tbody");
            products.forEach(prod => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <th>${prod.id}</th>
                    <td>${prod.titulo}</td>
                    <td>${prod.origen}</td>
                    <td>${prod.precio}</td>
                    <td>Publicado</td>
                    <td>
                        <button class='button-product-actions edit' data-product-id="${prod.id}" onclick='showEditForm(this)'> 
                            <svg xmlns='http://www.w3.org/2000/svg' width='40px' height='40px' viewBox='0 0 24 24'>
                                <g fill='none' stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5'>
                                    <path d='M9.533 11.15A1.82 1.82 0 0 0 9 12.438V15h2.578c.483 0 .947-.192 1.289-.534l7.6-7.604a1.82 1.82 0 0 0 0-2.577l-.751-.751a1.82 1.82 0 0 0-2.578 0z'/>
                                    <path d='M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3'/>
                                </g>
                            </svg>
                        </button>
                    </td>
                    <td>
                        <button class='button-product-actions delete' data-product-id="${prod.id}" onclick='disableProduct(event, this)'> 
                            <svg xmlns='http://www.w3.org/2000/svg' width='40px' height='40px' viewBox='0 0 24 24'>
                                <path fill='currentColor' d='M12 7c2.76 0 5 2.24 5 5c0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7M2 4.27l2.28 2.28l.46.46A11.8 11.8 0 0 0 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22L21 20.73L3.27 3zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65c0 1.66 1.34 3 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53c-2.76 0-5-2.24-5-5c0-.79.2-1.53.53-2.2m4.31-.78l3.15 3.15l.02-.16c0-1.66-1.34-3-3-3z'/>
                            </svg>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        } else {
            el.classList.add('button-show-products')
            el.textContent = "No hay más productos para cargar";
        }
    } catch (error) {
        console.error("Error cargando productos:", error);
    }
}


async function disableProduct(ev, el) {
    const productId = el.getAttribute('data-product-id');
    if (confirm("Estás seguro que deseas desactivar el producto?")) {
    try {
        const response = await fetch("http://localhost/admin/productos?action=dis_producto", {
            method: 'PUT',
            headers: { 'Content-type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'id_product': productId
            })
        })
        const textRes = await response.text();
        console.log(textRes);
        const result = JSON.parse(textRes);
        if (result.status === 'success') {
            const row = el.closest('tr');
            
            el.innerHTML = '';
            el.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5M12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5s5 2.24 5 5s-2.24 5-5 5m0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3"/></svg';
            row.style.cursor = 'not-allowed'
            row.classList.add('table-row-disabled');
            await new Promise(resolve => setTimeout(resolve, 2000));
            row.remove();
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.log(`Error :${error}`);
    } }

}

async function productsForm() {
    const imageInput = document.getElementById('images');

    if (imageInput.files.length > 6) {
        msgContainer.style.display = 'flex';
        msgContainer.style.margin = '1rem 0';
        const msgParrafo = msgContainer.querySelector('p');
        if (msgParrafo) {
            msgParrafo.innerHTML = "Superaste el máximo permitido de imagenes";
        }
        return;
    }
    const productsData = new FormData(formProducts);
    productsData.append('submit', 'submit');
    const msgParrafo = msgContainer.querySelector('p')
    try {
    const response = await fetch("http://localhost/admin/productos?action=agregar_producto",
         {
    method: 'POST',
    body: productsData
    })
    const data = await response.json() 
    msgContainer.style.display = 'flex';
    
    if (msgParrafo) {
        msgContainer.classList.add('error-prod');
        msgContainer.style.margin = '1rem 0';
        msgParrafo.innerHTML = data.mssg; 
    }
    if (data.success) {
        msgContainer.classList.add('success-prod');
        formProducts.reset();
    }
}
    catch(err) {
        msgContainer.style.display = 'flex';
        msgContainer.style.margin = '1rem 0';
    if (msgParrafo) {
        msgContainer.style.margin = '1rem 0';
        msgParrafo.innerHTML = `Error: ${err}`;
    }
}
};