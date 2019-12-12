<?php
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD']);

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
    'POST'
);

$router->add(
    'register',
    ['controller' => 'Members', 'action' => 'create'],
    'POST'
);

$router->add(
    'circuits',
    ['controller' => 'Circuits', 'action' => 'show'],
);

// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
