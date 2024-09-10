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

    <title>Ajustes</title>
</head>

<body>
    <?php
    // Mostrar la barra de navegación según el usuario.
    showNavbar($user);
    ?>

    <div class="container textCenter">
        <form action="index.php?action=ajustes" method="POST">
            <h1>Ajustes</h1>
            <button type="submit">Cerrar Sesión</button>
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