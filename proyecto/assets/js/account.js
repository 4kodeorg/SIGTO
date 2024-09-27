const formLogin = document.getElementById('login-form');
const loginMsg = document.getElementById('login-message');
const registerForm = document.getElementById('registration-form');
const modalRedirect = document.getElementById('modal-redirect');
const registerMssg = document.getElementById('register-message');


async function registrationForm() {
    const registerData = new FormData(registerForm);
    registerData.append('submit', 'submit');

    try {
        const response = await fetch('http://localhost/registro?action=registrarse', {
            method: 'POST',
            body: registerData
        });

        const text = await response.text();
        const data = JSON.parse(text);

        if (data.success) {
            window.location.href = '/?u=' + data.id +"&d="+ Date.now();
        } else {
            console.log(data);
            registerMssg.style.display = 'flex';
            const msgFailedReg = registerMssg.querySelector('p');
            msgFailedReg.innerHTML = data.message || 'Ocurrió un error';
        }
    } catch (err) {
        registerMssg.style.display = 'flex';
        const msgFailedReg = registerMssg.querySelector('p');
        msgFailedReg.innerHTML = `Error: ${err}`;
    }
};

async function loginForm() {
    const loginData = new FormData(formLogin);
    loginData.append('submit', 'submit');

    try {
        const response = await fetch('http://localhost/cuenta?action=1', {
            method: 'POST',
            body: loginData
        });

        const text = await response.text();
        console.log("RESPUESTA EN TEXTO:", text);
        const data = JSON.parse(text);

        console.log("RESPUESTA EN JSON:", data);

        if (data.success) {
            window.location.href = '/?u=' + data.id + "&d=" +Date.now();
        } else {
            console.log(data);
            loginMsg.style.display = 'flex';
            const msgOnLogin = loginMsg.querySelector('p');
            if (msgOnLogin) {
                msgOnLogin.innerHTML = data.mssg || "Ocurrió un error";
            }
        }
    } catch (err) {
        loginMsg.style.display = 'flex';
        const msgOnLogin = loginMsg.querySelector('p');
        if (msgOnLogin) {
            msgOnLogin.innerHTML = `Error: ${err}`;
        }
    }
};

