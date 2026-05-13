<?php
/**
 * config/config.php
 * Archivo de configuración centralizado para la base de datos
 * 
 * Este archivo contiene todas las constantes necesarias para
 * conectarse a la base de datos MySQL usando PDO.
 */

// Configuración de la Base de Datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'el_faro');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configuración de errores (desarrollo)
define('APP_ENV', 'development'); // 'development' o 'production'
define('SHOW_ERRORS', true); // Mostrar errores en desarrollo

// Configuración de rutas
define('BASE_PATH', dirname(dirname(__FILE__)) . '/');
define('ASSETS_PATH', BASE_PATH . 'assets/');
define('MODELS_PATH', BASE_PATH . 'models/');
define('CONTROLLERS_PATH', BASE_PATH . 'controllers/');
define('VIEWS_PATH', BASE_PATH . 'views/');

?>
