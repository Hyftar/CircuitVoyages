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
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('circuits/', ['controller' => 'Circuits', 'action' => 'show']);

/**
 * Convert URI to QueryString
 */
preg_match_all(
    '/^\/?(.*?)\??((?:&?\w+\=?\w+)*)$/i',
    $_SERVER['REQUEST_URI'],
    $matches,
    PREG_SET_ORDER,
    0
);

$QueryString = $matches[0][1]; // Group 1: Controller/Action
if ($matches[0][2] != '') {
    $QueryString .= "&" . $matches[0][2]; // Group 2: params
}

$router->dispatch($QueryString); // Send the query string to the router