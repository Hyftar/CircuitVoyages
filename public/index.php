<?php
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'APPLICATION_ENV']);


if ($_ENV['APPLICATION_ENV'] == 'development') {
    SassCompiler::run(dirname(__DIR__) . '/App/Views/Scss/', dirname(__DIR__) . '/public/css/generated/');
}

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Starts user sessions
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add(
    '',
    ['controller' => 'Home', 'action' => 'index'],
);

$router->add(
    'login',
    ['controller' => 'Members', 'action' => 'login'],
);


$router->add(
    'circuits',
    ['controller' => 'Circuits', 'action' => 'show'],
);

$router->add(
    'admin',
    ['controller' => 'Admin', 'action' => 'admin'],
);

$router->add(
    'admin_circuits',
    ['controller' => 'Admin', 'action' => 'circuitsIndex'],
);

$router->add(
    'admin_circuits_create',
    ['controller' => 'Admin', 'action' => 'circuitsCreate']
);

// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
