<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../includes/functions.php';

$user = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

?>

<!DOCTYPE html>
<html lang="es">

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

    <title>Admin</title>
</head>

<!-- data-bs-theme="light" -->

<body>
    <?php
    // Mostrar la barra de navegación según el usuario.
    showNavbar($user);
    ?>

    <div class="container">
        <h1 class="textCenter">Admin</h1>
        <section id="mainArea" class="row row-cols-1 row-cols-md-3 g-4 text-center">
            <!-- Crear Género -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-text">
                        <form name="fCreateGenre" role="form" class="row g-3 formu" action="index.php?action=fCreateGenre" method="POST" novalidate>
                            <label for="nameGenero">
                                <h3>Crear Género: </h3>
                            </label>

                            <input type="text" class="form-control" id="nameGenero" name="nameGenero" placeholder="Nombre del género" required>

                            <button class="btn btn-success" id="btnCreateGenero" type="submit">
                                <i class="bi bi-plus-circle btnAdmin"> CREAR GÉNERO </i>
                            </button>

                            <!-- Javascript -->
                            <div id="nameGeneroError" class="error-message"></div>

                            <?php if (!empty($successCreateGen)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($successCreateGen); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorCreateGenre)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorCreateGenre); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Crear Estado -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-text">
                        <form name="fCreateStatus" role="form" class="row g-3 formu" action="index.php?action=fCreateStatus" method="POST" novalidate>
                            <label for="nameStatus">
                                <h3>Crear Estado: </h3>
                            </label>

                            <input type="text" class="form-control" id="nameStatus" name="nameStatus" placeholder="Nombre del estado" required>

                            <button class="btn btn-success" id="btnCreateStatus" type="submit">
                                <i class="bi bi-plus-circle btnAdmin"> CREAR ESTADO </i>
                            </button>

                            <!-- Javascript -->
                            <div id="nameStatusError" class="error-message"></div>

                            <?php if (!empty($successCreateStatus)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($successCreateStatus); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorCreateStatus)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorCreateStatus); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Eliminar Usuario -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-text">
                        <form name="fProcessUser" role="form" class="row g-3 formu" action="index.php?action=fProcessUser" method="POST" novalidate>
                            <label for="nameDelUser">
                                <h3>Eliminar Usuario: </h3>
                            </label>

                            <input type="text" class="form-control" id="nameDelUser" name="nameDelUser" placeholder="Nombre del Usuario" required>

                            <button class="btn btnColor" id="btnBuscarUser" type="submit" name="operation" value="searchUser">
                                <i class="bi bi-search btnAdmin"> BUSCAR USUARIO </i>
                            </button>

                            <?php if (!empty($usuarios)) : ?>
                                <label class="formuLabel" for="selecDelUsuario">Seleccione usuario(s): </label>
                                <select name="selecDelUsuario[]" class="form-select" id="selecDelUsuario" aria-describedby="selecDelUsuario" aria-label="label flotante usuario" multiple>
                                    <?php foreach ($usuarios as $user) : ?>
                                        <option value="<?php echo htmlspecialchars($user['IdUsuario']); ?>"><?php echo htmlspecialchars($user['Nombre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                            <?php if (!empty($usuarios)) : ?>
                                <button class="btn btnDelete" id="btnDeleteUser" type="submit" name="operation" value="deleteUser">
                                    <i class="bi bi-x-square btnAdmin"> ELIMINAR USUARIO </i>
                                </button>
                            <?php endif; ?>

                            <?php if (!empty($errorBusUser)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorBusUser); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($successMessageUser)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($successMessageUser); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorDelUser)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorDelUser); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Eliminar Géneros -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-text">
                        <form name="fDeleteGenero" role="form" class="row g-3 formu" action="index.php?action=fDeleteGenero" method="POST" novalidate>
                            <label for="selecDelGen">
                                <h3>Eliminar Generos: </h3>
                            </label>

                            <?php if (!empty($data['generos'])) : ?>
                                <select name="selecDelGen[]" class="form-select" id="selecDelGen" aria-describedby="selecDelGen" multiple>
                                    <?php foreach ($data['generos'] as $gen) : ?>
                                        <?php if ($gen['IdGenero'] !== 1) : ?>
                                            <option value="<?php echo htmlspecialchars($gen['IdGenero']); ?>">
                                                <?php echo htmlspecialchars($gen['Nombre']); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    No se encontraron los géneros.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <button class="btn btnDelete" id="btnDeleteGenero" type="submit">
                                <i class="bi bi-x-square btnAdmin"> ELIMINAR GENERO </i>
                            </button>

                            <?php if (!empty($successDelGen)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($successDelGen); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorDelGen)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorDelGen); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Eliminar Estados -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-text">
                        <form name="fDeleteStatus" role="form" class="row g-3 formu" action="index.php?action=fDeleteStatus" method="POST" novalidate>
                            <label for="selecDelStatus">
                                <h3>Eliminar Estados: </h3>
                            </label>

                            <?php if (!empty($data['estados'])) : ?>
                                <select name="selecDelStatus[]" class="form-select" id="selecDelStatus" aria-describedby="selecDelStatus" multiple>
                                    <?php foreach ($data['estados'] as $gen) : ?>
                                        <option value="<?php echo htmlspecialchars($gen['IdEstado']); ?>">
                                            <?php echo htmlspecialchars($gen['Nombre']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    No se encontraron los estados.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <button class="btn btnDelete" id="btnDeleteStatus" type="submit">
                                <i class="bi bi-x-square btnAdmin"> ELIMINAR ESTADO </i>
                            </button>

                            <?php if (!empty($successDelStatus)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($successDelStatus); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorDelStatus)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorDelStatus); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Eliminar Historias -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-text">
                        <form name="fDeleteHistoria" role="form" class="row g-3 formu" action="index.php?action=fDeleteHistoria" method="POST" novalidate>
                            <label for="nameDelHistoria">
                                <h3>Eliminar Historia: </h3>
                            </label>

                            <input type="text" class="form-control" id="nameDelHistoria" name="nameDelHistoria" placeholder="Nombre de la Historia" required>

                            <button class="btn btnColor" id="btnBuscarHistoria" type="submit" name="operation" value="searchStory">
                                <i class="bi bi-search btnAdmin"> BUSCAR HISTORIA/AUTOR </i>
                            </button>

                            <?php if (!empty($historias)) : ?>
                                <label class="formuLabel" for="selecDelHistoria">Seleccione historia(s): </label>
                                <select name="selecDelHistoria[]" class="form-select" id="selecDelHistoria" aria-describedby="selecDelHistoria" multiple>
                                    <?php foreach ($historias as $story) : ?>
                                        <option value="<?php echo htmlspecialchars($story['IdHistoria']); ?>">'<?php echo htmlspecialchars($story['Titulo']); ?>' - '<?php echo htmlspecialchars($story['Nombre']); ?>'</option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                            <?php if (!empty($historias)) : ?>
                                <button class="btn btnDelete" id="btnDeleteHistoria" type="submit" name="operation" value="deleteStory">
                                    <i class="bi bi-x-square btnAdmin"> ELIMINAR HISTORIA </i>
                                </button>
                            <?php endif; ?>

                            <?php if (!empty($errorBusStory)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorBusStory); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($successStory)) : ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($successStory); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($errorDelStory)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($errorDelStory); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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