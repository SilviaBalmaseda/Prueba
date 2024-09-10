<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/DaoGenero.php';
require_once __DIR__ . '/../models/DaoEstado.php';
require_once __DIR__ . '/../models/DaoHistoria.php';
require_once __DIR__ . '/../models/DaoUsuario.php';
require_once __DIR__ . '/../models/DaoLogin.php';

class Controller
{
    private $daoGenero;
    private $daoEstado;
    private $daoHistoria;
    private $daoUsuario;
    private $daoLogin;

    public function __construct($db)
    {
        $this->daoGenero = new DaoGenero($db);
        $this->daoEstado = new DaoEstado($db);
        $this->daoHistoria = new DaoHistoria($db);
        $this->daoUsuario = new DaoUsuario($db);
        $this->daoLogin = new DaoLogin($db);
    }

    // public function index()
    // {
    //     // Array con los nombres de los generos y las historias que hay.
    //     $generos = $this->daoGenero->selecGenero() ?: [];
    //     $storysCards = $this->daoHistoria->selecStoryCard(null) ?: [];

    //     // Por defecto 8 historias por cada página.
    //     $historiasPorPagina = 8;

    //     // Calcula el total de historias (opcionalmente por género)
    //     $totalHistorias = $this->daoHistoria->selecNumHistoria(null);

    //     // Calcula el total de páginas
    //     $totalPaginas = ceil($totalHistorias / $historiasPorPagina);

    //     // Obtén la página actual desde GET (por defecto es 1 si no se especifica)
    //     $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    //     include 'views/index.php';
    // }

    // Muestra(pasa datos para) la interfaz de index(página principal).
    public function index()
    {
        $generos = $this->daoGenero->selecGenero() ?: [];

        // Número de historias por página.
        $historiasPorPagina = 8;

        // Obtiene el ID del género desde GET, si existe.
        $generoId = isset($_GET['nombre']) ? (int)$_GET['nombre'] : null;

        // Obtiene el número total de historias, filtrado por género si es necesario.
        $totalHistorias = $this->daoHistoria->selecNumHistoria($generoId);

        // Calcula el número total de páginas.
        $totalPaginas = ceil($totalHistorias / $historiasPorPagina);

        // Obtiene la página actual desde GET (por defecto es 1 si no se especifica).
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Validar la página actual para estar dentro de los límites.
        if ($paginaActual < 1) {
            $paginaActual = 1;
        } elseif ($paginaActual > $totalPaginas) {
            $paginaActual = $totalPaginas;
        }

        // Calcula el índice de inicio y fin de las historias para la página actual.
        $inicio = ($paginaActual - 1) * $historiasPorPagina;
        $fin = min($inicio + $historiasPorPagina, $totalHistorias);

        // Obtiene todas las historias filtradas por género y luego recorta el arreglo para mostrar solo las historias correspondientes a la página actual.
        if ($generoId !== null) {
            $todasLasHistorias = $this->daoHistoria->selecStoryIdGenero($generoId);
        } else {
            $todasLasHistorias = $this->daoHistoria->selecStoryCard(null) ?: [];
        }

        $storysCards = array_slice($todasLasHistorias, $inicio, $historiasPorPagina);

        // Pasa las variables a la vista.
        include 'views/index.php';
    }

    public function searchStory()
    {
        $searchStory = isset($_GET['searchStory']) ? $_GET['searchStory'] : null;
    }

    // Para LOGIN
    // Comprobar el usuario y la contraseña, después añade una sesión para la página.
    public function iniciarSesion()
    {
        if (($_POST['nameUser'] != '') && ($_POST['clave'] != '')) {
            $nameUser = $_POST['nameUser'];
            $clave = sha1($_POST['clave']);

            // Verificar si ese usuario tiene esa contraseña.
            if ($this->daoUsuario->checkSession($nameUser, $clave)) {
                $this->daoLogin->insertLogin($nameUser, $clave, 'C');

                $_SESSION['usuario'] = $nameUser;  // Creamos la variable de sesión para ese usuario

                if ($nameUser === 'admin') {
                    $_SESSION['userAdmin'] = "TRUE";
                } else {
                    $_SESSION['userAdmin'] = "FALSE";
                }

                header('Location: index.php');
                exit();
            } else {
                // Verificar si existe ese usuario.
                if ($this->daoUsuario->checkUser($nameUser)) {
                    $this->daoLogin->insertLogin($nameUser, $clave, 'D');
                }

                $error = "Usuario/Clave incorrecto. Vuelve a intentarlo.";
                include 'views/iniciarSesion.php';
            }
        }
        // else {
        //     $error = "Debes introducir el nombre de usuario y la contraseña.";
        //     include 'views/iniciarSesion.php';
        // }
    }

    // Comprueba que no está ese usuario y lo añade a la BBDD, luego llama a 'iniciarSesion()'.
    public function registrar()
    {
        $nameUser = $_POST['nameUser'];
        $clave = sha1($_POST['clave']);
        $email = $_POST['email'];

        if (!$this->daoUsuario->checkUser($nameUser)) {
            $this->daoUsuario->createUser($nameUser, $clave, $email);
            $this->iniciarSesion();
        } else {
            $error = "Introduce otro Nombre de Usuario.";
            include 'views/registrar.php';
        }
    }

    // Devuelve un array con los datos necesarios para el Admin.
    private function loadAdminData()
    {
        // Array con los nombres de los generos y estados que hay.
        $generos = $this->daoGenero->selecGenero() ?: [];
        $estados = $this->daoEstado->selecEstado() ?: [];

        // Array con los ids, titulo y nombre de usuarios de las historias que hay.
        $historias = $this->daoHistoria->selecHistoria() ?: [];

        // Array con los ids y nombres de los usuarios que hay.
        $userData = $this->daoUsuario->selecUserData() ?: [];

        return [
            'generos' => $generos,
            'estados' => $estados,
            'historias' => $historias,
            'userData' => $userData
        ];
    }

    // Devuelve un array con los datos necesarios para CrearHistoria.
    private function loadCreateStoryData()
    {
        // Array con los nombres de los generos y estados que hay.
        $generos = $this->daoGenero->selecGenero() ?: [];
        $estados = $this->daoEstado->selecEstado() ?: [];

        // Array con algunos datos de las historias del usuario que está en la sesión.
        $autorStory = $this->daoHistoria->selecAutorStory($_SESSION['usuario']) ?: [];

        return [
            'generos' => $generos,
            'estados' => $estados,
            'autorStory' => $autorStory
        ];
    }

    //CREAR HISTORIA
    // Muestra(pasa datos para) la interfaz de crearHistoria.
    public function showCrearHistoria()
    {
        $data = $this->loadCreateStoryData();
        include 'views/crearHistoria.php';
    }

    public function createStory() {}

    public function editStory()
    {
        //
    }

    public function deleteStory()
    {
        //
    }

    // ADMIN
    // Muestra(pasa datos para) la interfaz de admin.
    public function admin()
    {
        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Crear un nuevo género.
    public function crearGenero()
    {
        if ((isset($_POST['nameGenero'])) && ($_POST['nameGenero'] != '')) {
            $nameGenero = $_POST['nameGenero'];

            // Comprobar si el género ya existe.
            if ($this->daoGenero->checkGenero($nameGenero) < 1) {
                $this->daoGenero->createGenero($nameGenero);
                $successCreateGen  = "Género creado correctamente.";
            } else {
                $errorCreateGenre = "Ya está ese nombre de GÉNERO. Prueba otro.";
            }
        } else {
            $errorCreateGenre = "Tienes que introducir un nombre para el Género";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Crear un nuevo estado.
    public function crearEstado()
    {
        if ((isset($_POST['nameStatus'])) && ($_POST['nameStatus'] != '')) {
            $nameStatus = $_POST['nameStatus'];

            // Comprobar si el estado ya existe.
            if ($this->daoEstado->checkEstado($nameStatus) < 1) {
                $this->daoEstado->createEstado($nameStatus);
                $successCreateStatus  = "Estado creado correctamente.";
            } else {
                $errorCreateStatus = "Ya está ese nombre de ESTADO. Prueba otro.";
            }
        } else {
            $errorCreateStatus = "Tienes que introducir un nombre para el Estado";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Busca los usuarios con un nombre parecido al que ha pasado.
    public function buscarUsuario()
    {
        if ((isset($_POST['nameDelUser'])) && ($_POST['nameDelUser'] != '')) {
            $nameDelUser = $_POST['nameDelUser'];
            $usuarios = $this->daoUsuario->selecUsuario($nameDelUser);

            if (empty($usuarios)) {
                $errorBusUser = "No se encontraron usuarios con ese nombre";
            }
        } else {
            $errorBusUser = "Tienes que introducir un nombre para buscar";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Elimina los usuarios seleccionados.
    public function eliminarUsuario()
    {
        if (isset($_POST['selecDelUsuario']) && is_array($_POST['selecDelUsuario'])) {
            $selecDelUsuarios = $_POST['selecDelUsuario'];

            foreach ($selecDelUsuarios as $idUser) {
                $this->daoUsuario->deleteUser($idUser);
            }

            $successMessageUser  = "Usuario(s) eliminado(s) correctamente";
        } else {
            $errorDelUser = "Tienes que seleccionar algún usuario para eliminarlo";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Elimina los géneros seleccionados.
    public function eliminarGenero()
    {
        if (isset($_POST['selecDelGen']) && is_array($_POST['selecDelGen'])) {
            $selecDelGenero = $_POST['selecDelGen'];

            foreach ($selecDelGenero as $idGenero) {
                $this->daoGenero->deleteGenero($idGenero);
            }

            $successDelGen  = "Género(s) eliminado(s) correctamente.";
        } else {
            $errorDelGen = "Tienes que seleccionar algún género para eliminarlo.";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Elimina los estados seleccionados.
    public function eliminarEstado()
    {
        if (isset($_POST['selecDelStatus']) && is_array($_POST['selecDelStatus'])) {
            $selecDelEstado = $_POST['selecDelStatus'];

            foreach ($selecDelEstado as $idEstado) {
                $this->daoEstado->deleteEstado($idEstado);
            }

            $successDelStatus  = "Estados(s) eliminado(s) correctamente.";
        } else {
            $errorDelStatus = "Tienes que seleccionar algún estado para eliminarlo.";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Busca las historias y los usuarios con un nombre parecido al que ha pasado.
    public function buscarHistoria()
    {
        if ((isset($_POST['nameDelHistoria'])) && ($_POST['nameDelHistoria'] != '')) {
            $nameDelHistoria = $_POST['nameDelHistoria'];
            $historias = $this->daoHistoria->selecHistoriaAutor($nameDelHistoria);

            if (empty($historias)) {
                $errorBusStory = "No se encontraron ni historias ni autor con ese nombre";
            }
        } else {
            $errorBusStory = "Tienes que introducir un nombre para buscar";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    // Elimina las historias seleccionadas.
    public function eliminarHistoria()
    {
        if (isset($_POST['selecDelHistoria']) && is_array($_POST['selecDelHistoria'])) {
            $selecDelHistoria = $_POST['selecDelHistoria'];

            foreach ($selecDelHistoria as $historiaId) {
                $this->daoHistoria->deleteHistoria($historiaId);
            }

            $successStory  = "Historia(s) eliminada(s) correctamente";
        } else {
            $errorDelStory = "Tienes que seleccionar alguna historia para eliminarla";
        }

        $data = $this->loadAdminData();
        include 'views/admin.php';
    }

    //AJUSTES
    // Muestra(pasa datos para) la interfaz de ajustes.
    public function ajustes()
    {
        session_destroy();

        header('Location: index.php');
    }
}
