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
 * Routig
 */
$router = new Core\Router();

// Add the routes
$router->add(
    '',
    ['controller' => 'Home', 'action' => 'index']
);

$router->add(
    'admin/media',
    ['controller' => 'Medias', 'action' => 'index'],
);


$router->add(
    'admin/media',
    ['controller' => 'Medias', 'action' => 'upload'],
    'POST'
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
    'promotions/deactivate',
    ['controller' => 'Promotions', 'action' => 'deactivate'],
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
    'promotions/application',
    ['controller' => 'Promotions', 'action' => 'getApplication'],
    'POST'
);

$router->add(
    'login',
    ['controller' => 'Members', 'action' => 'login'],
    'POST'
);

$router->add(
    'login/google',
    ['controller' => 'Members', 'action' => 'googleLogin'],
    'POST'
);

$router->add(
    'login/facebook',
    ['controller' => 'Members', 'action' => 'facebookLogin'],
    'POST'
);

$router->add(
    'logout',
    ['controller' => 'Members', 'action' => 'logout'],
    'DELETE'
);

$router->add(
    'admin/login',
    ['controller' => 'Employees', 'action' => 'showLogin'],
    'GET'
);

$router->add(
    'admin/login',
    ['controller' => 'Employees', 'action' => 'login'],
    'POST'
);

$router->add(
    'register',
    ['controller' => 'Members', 'action' => 'create'],
    'POST'
);

$router->add(
    'logout',
    ['controller' => 'Members', 'action' => 'logout'],
    'DELETE'
);

$router->add(
    'admin',
    ['controller' => 'Admin', 'action' => 'admin']
);

$router->add(
    'admin/login',
    ['controller' => 'Employees', 'action' => 'showLogin'],
    'GET'
);

$router->add(
    'admin/login',
    ['controller' => 'Employees', 'action' => 'login'],
    'POST'
);

$router->add(
    'admin/logout',
    ['controller' => 'Employees', 'action' => 'logout'],
    'DELETE'
);

$router->add(
    'admin_accommodation',
    ['controller' => 'Admin', 'action' => 'accommodationIndex']
);

$router->add(
    'admin_accommodation',
    ['controller' => 'Admin', 'action' => 'accommodationCreate'],
    'POST'
);

$router->add(
    'admin/activity',
    ['controller' => 'Admin', 'action' => 'activityIndex']
);

$router->add(
    'admin/activity',
    ['controller' => 'Admin', 'action' => 'activityCreate'],
    'POST'
);

$router->add(
    'admin_circuits',
    ['controller' => 'Admin', 'action' => 'circuitsIndex']
);

$router->add(
    'admin_circuits_create',
    ['controller' => 'Admin', 'action' => 'circuitsCreateIndex']
);

$router->add(
    'admin_circuits_create_save',
    ['controller' => 'Admin', 'action' => 'circuitsCreate']
);

$router->add(
    'admin_circuits_addstep_link',
    ['controller' => 'Admin', 'action' => 'circuitsAddStepLink'],
    'POST'
);

$router->add(
    'promotions/createApplication',
    ['controller' => 'Promotions', 'action' => 'updatePromotionCircuits'],
    'POST'
);

$router->add(
    'admin_circuits_addstep_tab',
    ['controller' => 'Admin', 'action' => 'circuitsAddStepTab'],
);

$router->add(
    'admin_circuits_activity_create',
    ['controller' => 'Admin', 'action' => 'circuitsActivityCreate'],
    'POST'
);

$router->add(
    'admin_circuits_organize',
    ['controller' => 'Admin', 'action' => 'circuitsOrganize']
);

$router->add(
    'admin/circuit_create_simple',
    ['controller' => 'Admin', 'action' => 'circuitsCreateSimple'],
    'POST'
);

$router->add(
    'admin_circuit_update',
    ['controller' => 'Admin', 'action' => 'circuitUpdateIndex'],
    'POST'
);

$router->add(
    'admin/circuit_update_simple',
    ['controller' => 'Admin', 'action' => 'circuitsUpdateSimple'],
    'POST'
);

$router->add(
    'admin/deleteCircuit',
    ['controller' => 'Admin', 'action' => 'deleteCircuit'],
    'POST'
);

$router->add(
    'admin/deleteCircuitTrip',
    ['controller' => 'Admin', 'action' => 'deleteCircuitTrip'],
    'POST'
);

$router->add(
    'admin/circuitTrips',
    ['controller' => 'Admin', 'action' => 'getCircuitTrips'],
    'POST'
);

$router->add(
'admin/circuit_trip_create_modal',
    ['controller' => 'Admin', 'action' => 'getCircuitTripCreateModal'],
    'POST'
);

$router->add(
    'admin/circuit_trip_create',
    ['controller' => 'Admin', 'action' => 'getCircuitTripCreate'],
    'POST'
);

$router->add(
    'admin/circuit_trip_update_modal',
    ['controller' => 'Admin', 'action' => 'getCircuitTripUpdateModal'],
    'POST'
);

$router->add(
    'admin/circuit_trip_update',
    ['controller' => 'Admin', 'action' => 'getCircuitTripUpdate'],
    'POST'
);

// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
