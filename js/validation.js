document.addEventListener('DOMContentLoaded', function() {
    const fIniciarSesion = document.querySelector('.fIniciarSesion');
    const fRegistrar = document.querySelector('.fRegistrar');
    
    const fCreateGenre = document.querySelector('.fCreateGenre');
    const fCreateStatus = document.querySelector('.fCreateStatus');



    

    // Iniciar Sesión.
    if (fIniciarSesion) {
        fIniciarSesion.addEventListener('submit', function(event) {
            // Obtener los valores de los campos
            const nameUser = document.getElementById('nameUser').value.trim();
            const clave = document.getElementById('clave').value.trim();
            
            let isValid = true;
            
            // Limpiar mensajes de error
            document.getElementById('nameUserError').textContent = '';
            document.getElementById('claveError').textContent = '';
            
            // Validar nombre de usuario
            if (nameUser === '') {
                document.getElementById('nameUserError').textContent = 'El NOMBRE de USUARIO es obligatorio.';
                isValid = false;
            }
            
            // Validar contraseña
            if (clave === '') {
                document.getElementById('claveError').textContent = 'La CONTRASEÑA es obligatoria.';
                isValid = false;
            }
            
            // Si hay errores, evitar el envío del formulario
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    // Registrar.
    if (fRegistrar) {
        fRegistrar.addEventListener('submit', function(event) {
            // Obtener los valores de los campos
            const nameUser = document.getElementById('nameUser').value.trim();
            const clave = document.getElementById('clave').value.trim();
            const email = document.getElementById('email').value.trim();
            
            let isValid = true;
            
            // Limpiar mensajes de error
            document.getElementById('nameUserError').textContent = '';
            document.getElementById('claveError').textContent = '';
            document.getElementById('emailError').textContent = '';
            
            // Validar nombre de usuario
            if (nameUser === '') {
                document.getElementById('nameUserError').textContent = 'El NOMBRE de USUARIO es obligatorio.';
                isValid = false;
            }
            
            // Validar contraseña
            if (clave === '') {
                document.getElementById('claveError').textContent = 'La CONTRASEÑA es obligatoria.';
                isValid = false;
            }

            // Validar email
            if (email != '') {
                document.getElementById('emailError').textContent = 'Tienes que seguir el patrón: nefelibata@gmail.com';
                isValid = false;
            }
            
            // Si hay errores, evitar el envío del formulario
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    // Admin 
    // Crear Género.
    if (fCreateGenre) {
        fCreateGenre.addEventListener('submit', function(event) {
            const nameGenero = document.getElementById('nameGenero').value.trim();
            
            let isValid = true;
            
            // Limpiar mensajes de error
            document.getElementById('nameGeneroError').textContent = '';
            
            // Validar nombre de usuario
            if (nameGenero === '') {
                document.getElementById('nameGeneroError').textContent = 'El NOMBRE de GÉNERO no puede ser vacío.';
                isValid = false;
            }
            
            // Si hay errores, evitar el envío del formulario
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    // Crear Estado.
    if (fCreateStatus) {
        fCreateStatus.addEventListener('submit', function(event) {
            const nameStatus = document.getElementById('nameStatus').value.trim();
            
            let isValid = true;
            
            // Limpiar mensajes de error
            document.getElementById('nameStatusError').textContent = '';
            
            // Validar nombre de usuario
            if (nameStatus === '') {
                document.getElementById('nameStatusError').textContent = 'El NOMBRE de ESTADO no puede ser vacío.';
                isValid = false;
            }
            
            // Si hay errores, evitar el envío del formulario
            if (!isValid) {
                event.preventDefault();
            }
        });
    }

});
