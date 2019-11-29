<?php
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

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
    '',
    ['controller' => 'Home', 'action' => 'indexPost'],
    'POST'
);


$router->add(
    'circuits',
    ['controller' => 'Circuits', 'action' => 'show'],
);

// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
