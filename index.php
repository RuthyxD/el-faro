<?php
// index.php - Archivo principal y enrutador básico

// Obtener parámetros de la URL
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Enrutar según el controlador y acción
switch ($controller) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $homeController = new HomeController();
        $homeController->index();
        break;
    case 'contacto':
        require_once 'controllers/ContactoController.php';
        $contactoController = new ContactoController();
        if ($action == 'formulario') {
            $contactoController->formulario();
        } elseif ($action == 'procesar') {
            $contactoController->procesar();
        } else {
            // Acción no válida, redirigir a formulario
            header('Location: index.php?controller=contacto&action=formulario');
        }
        break;
    case 'usuario':
        require_once 'controllers/UsuarioController.php';
        $usuarioController = new UsuarioController();
        if ($action == 'registro') {
            $usuarioController->registro();
        } elseif ($action == 'registrar') {
            $usuarioController->registrar();
        } else {
            // Acción no válida, redirigir a registro
            header('Location: index.php?controller=usuario&action=registro');
        }
        break;
    default:
        // Controlador no válido, redirigir a home
        header('Location: index.php');
        break;
}
?>