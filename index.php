<?php

require_once __DIR__  .  '/config/db.php';
require_once __DIR__  .  '/controllers/Controller.php';
// require_once 'config/db.php';
// require_once 'controllers/Controller.php';

$controller = new Controller($pdo);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'iniciarSesion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->iniciarSesion();
        } else {
            include 'views/iniciarSesion.php';
        }
        break;
    case 'registrar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->registrar();
        } else {
            include 'views/registrar.php';
        }
        break;
    case 'crearHistoria':
        $controller->showCrearHistoria();
        break;
    case 'fSearchStory':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->searchStory();
        } else {
            include 'views/index.php';
        }
        break;
    case 'formCreateH':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $operation = $_POST['operation'] ?? '';

            if ($operation === 'btnCreateH') {
                $controller->createStory();
            } elseif ($operation === 'btnEditH') {
                $controller->editStory();
            } elseif ($operation === 'btnDeleteH') {
                $controller->deleteStory();
            }
        } else {
            include 'views/admin.php';
        }
        break;

    case 'admin':
        $controller->admin();
        break;
    case 'fCreateGenre':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->crearGenero();
        } else {
            include 'views/admin.php';
        }
        break;
    case 'fCreateStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->crearEstado();
        } else {
            include 'views/admin.php';
        }
        break;
    case 'fSearchUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->buscarUsuario();
        } else {
            include 'views/admin.php';
        }
        break;
    case 'fProcessUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $operation = $_POST['operation'] ?? '';

            if ($operation === 'searchUser') {
                $controller->buscarUsuario();
            } elseif ($operation === 'deleteUser') {
                $controller->eliminarUsuario();
            }
        } else {
            include 'views/admin.php';
        }
        break;
    case 'fDeleteGenero':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->eliminarGenero();
        } else {
            include 'views/admin.php';
        }
        break;
    case 'fDeleteStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->eliminarEstado();
        } else {
            include 'views/admin.php';
        }
        break;
    case 'fDeleteHistoria':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $operation = $_POST['operation'] ?? '';

            if ($operation === 'searchStory') {
                $controller->buscarHistoria();
            } elseif ($operation === 'deleteStory') {
                $controller->eliminarHistoria();
            }
        } else {
            include 'views/admin.php';
        }
        break;
    case 'ajustes':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->ajustes();
        } else {
            include 'views/ajustes.php';
        }
        break;
    default:
        $controller->index();
        break;
}
