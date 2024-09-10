<!DOCTYPE html>
<html lang="es">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__  . '/../includes/functions.php';

$user = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

?>

<head>
    <?php
    // Escribir todos los links necesarios.
    if (file_exists(__DIR__  . '/../includes/linksHead.php')) {
        include __DIR__  . '/../includes/linksHead.php';
    } else {
        echo '<p>Error: El archivo de linksHead no se encontró.</p>';
        exit; // Detener la ejecución si el archivo no se encuentra.
    }
    ?>

    <title>Iniciar Sesión</title>
</head>

<body>
    <?php
    // Mostrar la barra de navegación según el usuario.
    showNavbar($user);
    ?>

    <div class="container textCenter">
        <h1>Iniciar Sesión</h1>
        <form action="index.php?action=iniciarSesion" method="POST" class="fIniciarSesion" role="form" novalidate>
            <label for="nameUser">Nombre de Usuario: </label>
            <input type="text" id="nameUser" name="nameUser" required>
            <label for='clave'>Contraseña: </label>
            <input type='password' id='clave' name='clave' required>

            <div id="nameUserError" class="error-message"></div>
            <div id="claveError" class="error-message"></div>
            <?php if (!empty($error)) : ?>
                <h5 class="error-message"><?php echo htmlspecialchars($error); ?></h5>
            <?php endif; ?>

            <button type="submit" class="btn btnColor">Iniciar Sesion</button>
        </form>
    </div>

    <?php
    // Mostrar el pie de página.
    showFooter();
    ?>

    <?php
    // Escribier los scripts.
    if (file_exists(__DIR__  . '/../includes/scripts.php')) {
        include __DIR__  . '/../includes/scripts.php';
    } else {
        echo '<p>Error: El archivo de scripts no se encontró.</p>';
        exit; // Detener la ejecución si el archivo no se encuentra.
    }
    ?>
</body>

</html>