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

    <title>Registrarse</title>
</head>

<body>
    <?php
    // Mostrar la barra de navegación según el usuario.
    showNavbar($user);
    ?>

    <div class="container textCenter">
        <h1>Registrarse</h1>
        <form action="index.php?action=registrar" method="POST" class="fRegistrar" role="form" novalidate>
            <label for="nameUser">
                <h5>Nombre de Usuario: </h5>
            </label>
            <input type="text" id="nameUser" name="nameUser" required>
            <label for="clave">
                <h5>Contraseña: </h5>
            </label>
            <input type="password" id="clave" name="clave" required>
            <label for="email">
                <h5>Email: </h5>
            </label>
            <input type="email" id="email" name="email" placeholder="nefelibata@gmail.com" title="nombre + @ + terminación">

            <div id="nameUserError" class="error-message"></div>
            <div id="claveError" class="error-message"></div>
            <div id="emailError" class="error-message"></div>
            <button type="submit" class="btn btnColor">Registrarse</button>

            <?php if (!empty($error)) : ?>
                <h1><b><?php echo htmlspecialchars($error); ?></b></h1>
            <?php endif; ?>
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