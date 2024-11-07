const messageRegistro = document.getElementById('register-message');
const messageLogin = document.getElementById('login-message');
const formAdmin = document.getElementById('login-form-admin');
const registroAdmin = document.getElementById('registration-form-admin');
const server = window.location.origin;


async function adminRegistrationForm() {
    const formRegistro = new FormData(registroAdmin);
    formRegistro.append('submit', 'submit');

    try {
        const response = await fetch(`${server}/empresa?action=registrar_emp`, {
            method: 'POST',
            body: formRegistro
        });
        const data = await response.json();

        if (data.success) {
            window.location.href = data.url;
        } else {
            messageRegistro.style.display = 'flex';
            messageRegistro.querySelector('p').innerHTML = data.message || 'Ocurrió un error';
        }
    } catch (error) {
        console.error(`Error: ${error}`);
    }

}

async function adminLoginForm() {
    const formLoginData = new FormData(formAdmin)
    formLoginData.append('submit', 'submit');

    try {
        const response = await fetch(`${server}/admin_cuenta?action=login_adm`, {
            method: 'POST',
            body: formLoginData
        })
        const data = await response.json();

        if (data.success) {
            window.location.href = data.url;
        } else {
            messageLogin.style.display = 'flex'
            messageLogin.querySelector('p').innerHTML = data.message || "Ocurrió un error";
            
        }
    } catch (error) {
        console.error(`Error: ${error}`)
    }
}