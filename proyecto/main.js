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
        } else {

            messageInfo.style.display = 'flex';
            messageInfo.querySelector('p').innerHTML = data.message;
        }

    } catch(error) {
        console.log(`Error: ${error}}`)
    }
}

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

async function addCart () {
    const carritoData = new FormData(cartItem);
    carritoData.append('submit', 'submit');
    if (carritoData.get('id_user')) {
        try {
            const response = await fetch("", {
                method: 'POST',
                body: carritoData
            })
        } catch (error) {
    
        }
    } else {

    }
    
}
