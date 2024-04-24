function fetchUsuarios() {
    fetch('http://localhost/apisena/usuariopdo.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            // Puedes incluir otros headers según sea necesario
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error al obtener usuarios. Código de estado: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data && data.data) {
            displayUsuarios(data);
        } else {
            throw new Error('Respuesta de la API no tiene el formato esperado.');
        }
    })
    .catch(error => {
        console.error('Error:', error.message);
        displayError('Hubo un error al obtener usuarios. Por favor, inténtalo de nuevo.');
    });
}

function displayUsuarios(usuarios) {
    const usuariosContainer = document.getElementById('usuariosContainer');
    usuariosContainer.innerHTML = '';

    if (usuarios.data.length > 0) {
        usuarios.data.forEach(usuario => {
            const usuarioDiv = document.createElement('div');
            usuarioDiv.className = 'usuario-card';

            const usuarioInfo = `
                <p>ID: ${usuario.idusuario}</p>
                <p>Nombre: ${usuario.nombres}</p>
                <p>Correo: ${usuario.correo}</p>
                <p>Teléfono: ${usuario.telefono}</p>
            `;

            usuarioDiv.innerHTML = usuarioInfo;
            usuariosContainer.appendChild(usuarioDiv);
        });
    } else {
        displayError('No se encontraron usuarios.');
    }
}

function displayError(message) {
    const usuariosContainer = document.getElementById('usuariosContainer');
    usuariosContainer.innerHTML = `<p class="error-message">${message}</p>`;
}