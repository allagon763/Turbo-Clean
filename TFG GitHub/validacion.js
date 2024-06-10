// VALIDACIÓN DE LA CONTRASEÑA Y EL EMAIL

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    const passwordInput = document.getElementById('password');
    const emailInput = document.getElementById('email');
    const loginInput = document.getElementById('login');
    const errorMessage = document.createElement('div');
    errorMessage.id = 'error-message';
    errorMessage.style.color = 'red';
    form.insertBefore(errorMessage, form.firstChild);

    form.addEventListener('submit', async function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        const password = passwordInput.value;
        const email = emailInput.value;
        const login = loginInput.value;
        let messages = [];

        // Verificamos si la contraseña cumple con los requisitos
        if (!validatePassword(password)) {
            messages.push('La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula, un número y un carácter especial.');
        }

        // Verificamos si el email cumple con los requisitos
        if (!validateEmail(email)) {
            messages.push('El correo electrónico no es válido. Debe contener un "@" y un dominio válido.');
        }

        // Verificamos si el email o el nombre de usuario ya existen en la base de datos
        const userExists = await validateUniqueUser(email, login);
        if (userExists) {
            messages.push('El correo electrónico o el nombre de usuario ya están en uso.');
        }

        // Si hay mensajes de error, muestra el primero y evita el envío del formulario
        if (messages.length > 0) {
            errorMessage.textContent = messages.join(' ');
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';

            // Envía los datos al servidor para el registro
            const response = await fetch('procesar_registro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `nombre=${encodeURIComponent(form.nombre.value)}&login=${encodeURIComponent(login)}&password=${encodeURIComponent(password)}&email=${encodeURIComponent(email)}`,
            });

            const result = await response.text();
            if (result.includes('Registro exitoso')) {
                window.location.href = 'reservas.html'; // Redirige a la página de reservas
            } else {
                errorMessage.textContent = result;
                errorMessage.style.display = 'block';
            }
        }
    });

    function validatePassword(password) {
        const minLength = 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        return password.length >= minLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;
    }

    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    async function validateUniqueUser(email, login) {
        try {
            const response = await fetch('procesar_registro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=check_user&email=${encodeURIComponent(email)}&login=${encodeURIComponent(login)}`,
            });

            const data = await response.json();
            return data.exists;
        } catch (error) {
            console.error('Error al verificar el usuario:', error);
            return false;
        }
    }
});
