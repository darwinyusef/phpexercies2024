document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const mensajeDiv = document.getElementById('mensaje');

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const correo = document.getElementById('correo').value;
        const contrasena = document.getElementById('contrasena').value;

        // Enviar la solicitud POST a la API
        fetch('http://localhost/apisena/autentica.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `correo=${correo}&contrasena=${contrasena}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                mensajeDiv.innerText = data.message;
                // Puedes redirigir al usuario o realizar otras acciones después del inicio de sesión exitoso.
            } else {
                mensajeDiv.innerText = data.error || 'Error desconocido';
            }
        })
        .catch(error => {
            console.error('Error al enviar la solicitud:', error);
            mensajeDiv.innerText = 'Hubo un error al iniciar sesión. Por favor, inténtalo de nuevo.';
        });
    });
});