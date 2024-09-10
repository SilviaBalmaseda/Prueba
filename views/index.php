<!DOCTYPE html>
<html lang="es">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../includes/functions.php';

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

    <title>NEFELIBATA</title>
</head>

<body>
    <?php
    // Mostrar la barra de navegación según el usuario.
    showNavbar($user);
    ?>

    <div class="container">
        <h1 class="textCenter">GENEROS</h1>
        <div>
            <ul class="barraGenero">
                <?php if (!empty($generos)) : ?>
                    <?php foreach ($generos as $genero) : ?>
                        <li>
                            <div>
                                <?php if ($genero['Nombre'] != "Ninguno") : ?>
                                    <i class="bi bi-dash"></i>
                                    <a href="index.php?action=selec&nombre=<?php echo htmlspecialchars($genero['IdGenero']); ?>">
                                        <?php echo htmlspecialchars($genero['Nombre']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <span>No se encontraron géneros.</span>
                <?php endif; ?>
            </ul>
        </div>

        <?php if (!empty($storysCards)) : ?>
            <div id="CardsHistorias" class="row row-cols-1 row-cols-md-4 g-4 text-center container">
                <?php foreach ($storysCards as $story) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <h5 class="card-title"><?php echo htmlspecialchars($story['Titulo']); ?></h5>

                            <?php if ($story['Imagen']) : ?>
                                <img src='data:image/jpg;base64,<?php echo htmlspecialchars($story['Imagen']); ?>' class="card-img-top img-thumbnail" alt="Portada de la historia.">
                            <?php else: ?>
                                <img src="./img/sinImagen.png" class="card-img-top img-thumbnail" alt="No hay imagen disponible.">
                            <?php endif; ?>

                            <div class="card-body">
                                <button>Leer</button>
                                <button type="button" id="btnFavorito-<?php echo htmlspecialchars($story['Titulo']); ?>">
                                    <i class="bi bi-star-fill"><?php echo htmlspecialchars($story['NumFavorito']); ?></i>
                                </button>
                                <button>Sinopsis</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $paginaActual == 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $paginaActual - 1; ?><?php echo isset($generoNombre) ? '&nombre=' . urlencode($generoNombre) : ''; ?>" tabindex="-1">Previous</a>
                    </li>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                        <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo isset($generoNombre) ? '&nombre=' . urlencode($generoNombre) : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?php echo $paginaActual == $totalPaginas ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $paginaActual + 1; ?><?php echo isset($generoNombre) ? '&nombre=' . urlencode($generoNombre) : ''; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php else : ?>
            <span>No se encontraron las historias.</span>
        <?php endif; ?>
    </div>

    <?php
    // Mostrar el pie de página.
    showFooter();
    ?>

    <?php
    // Escribier los scripts.
    if (file_exists(__DIR__ .  '/../includes/scripts.php')) {
        include __DIR__ . '/../includes/scripts.php';
    } else {
        echo '<p>Error: El archivo de scripts no se encontró.</p>';
        exit; // Detener la ejecución si el archivo no se encuentra.
    }
    ?>
</body>

</html>