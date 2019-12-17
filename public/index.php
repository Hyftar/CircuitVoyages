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
    ['controller' => 'Home', 'action' => 'index']
);

$router->add(
    'promotions',
    ['controller' => 'Promotions', 'action' => 'indexCurrent']
);

$router->add(
    'promotions/all',
    ['controller' => 'Promotions', 'action' => 'index']
);

$router->add(
    'promotions/updatePromo',
    ['controller' => 'Promotions', 'action' => 'update'],
    'POST'
);

$router->add(
    'promotions/id',
    ['controller' => 'Promotions', 'action' => 'indexId'],
    'POST'
);

$router->add(
    'promotions/idModal',
    ['controller' => 'Promotions', 'action' => 'indexIdModal'],
    'POST'
);

$router->add(
    'promotions/emptyModal',
    ['controller' => 'Promotions', 'action' => 'emptyModal']
);

$router->add(
    'promotions/createPromo',
    ['controller' => 'Promotions', 'action' => 'create'],
    'POST'
);

$router->add(
    'circuits',
    ['controller' => 'Circuits', 'action' => 'show']
);

$router->add(
    'promotions/application',
    ['controller' => 'Promotions', 'action' => 'getApplication'],
    'POST'
);

$router->add(
    'promotions/createApplication',
    ['controller' => 'Promotions', 'action' => 'updatePromotionCircuits'],
    'POST'
);

$router->add(
    'promotions/deactivate',
    ['controller' => 'Promotions', 'action' => 'deactivate'],
    'POST'
);

// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
