<?php
/**
 * index.php
 * Archivo principal y enrutador básico del proyecto "El Faro"
 * 
 * Este archivo es el punto de entrada de la aplicación.
 * Implementa un sistema de ruteo básico que carga los controladores
 * según los parámetros de la URL.
 */

// Incluir configuración centralizada
require_once 'config/config.php';

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
        } elseif ($action == 'listar') {
            $usuarioController->listar();
        } else {
            // Acción no válida, redirigir a registro
            header('Location: index.php?controller=usuario&action=registro');
        }
        break;
    case 'articulo':
        require_once 'controllers/ArticuloController.php';
        $articuloController = new ArticuloController();
        if ($action == 'crear') {
            $articuloController->crear();
        } elseif ($action == 'obtener-por-seccion') {
            $seccion = $_GET['seccion'] ?? '';
            $articuloController->obtenerPorSeccion($seccion);
        } else {
            // Acción no válida, redirigir a home
            header('Location: index.php');
        }
        break;
    default:
        // Controlador no válido, redirigir a home
        header('Location: index.php');
        break;
}
?>