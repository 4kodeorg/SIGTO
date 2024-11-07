const formLogin = document.getElementById('login-form');
const loginMsg = document.getElementById('login-message');
const registerForm = document.getElementById('registration-form');
const modalRedirect = document.getElementById('modal-redirect');
const registerMssg = document.getElementById('register-message');
const servertwo = window.location.origin;

const APIlogin = `${servertwo}/cuenta?action=1`;
const APIregistro = `${servertwo}/registro?action=registrarse`;


async function fsr (api, methodApi, dataBody, domEl) {
    try {
        const response = await fetch(api, {
            method: methodApi,
            body: dataBody
        })
        const dataText = await response.text();
        console.log(dataText);
        const data = JSON.parse(dataText);

        if (data.success) {
            window.location.href = data.url
        }
        else {
            domEl.style.display = 'flex';
            const msgCont = domEl.querySelector('p');
            msgCont.innerHTML = data.message || 'Ocurrió un error';
        }
    } catch (error) {
        domEl.style.display = 'flex';
        const msgCont = domEl.querySelector('p');
        msgCont.innerHTML = `Error: ${error}`;
    }
}

async function registrationForm() {
    const registerData = new FormData(registerForm);
    registerData.append('submit', 'submit');
    fsr(APIregistro, 'POST', registerData, registerMssg);

};

async function loginForm() {
    const loginData = new FormData(formLogin);
    loginData.append('submit', 'submit');
    fsr(APIlogin, 'POST', loginData, loginMsg);
};

