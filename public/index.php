<?php
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'APPLICATION_ENV']);


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


/* ADMIN PAGES */

$router->add('admin', ['controller' => 'Admin', 'action' => 'admin']);

$router->add('admin/accommodation', ['controller' => 'Admin', 'action' => 'accommodationIndex']);
$router->add('admin/accommodation', ['controller' => 'Admin', 'action' => 'accommodationCreate'], 'POST');

$router->add('admin/activity', ['controller' => 'Admin', 'action' => 'activityIndex']);
$router->add('admin/activity', ['controller' => 'Admin', 'action' => 'activityCreate'], 'POST');

$router->add('admin/circuit_create_simple', ['controller' => 'Admin', 'action' => 'circuitsCreateSimple'], 'POST');

$router->add('admin/circuit_trips', ['controller' => 'Admin', 'action' => 'getCircuitTrips'], 'POST');
$router->add('admin/circuit_trip_create_modal', ['controller' => 'Admin', 'action' => 'getCircuitTripCreateModal'], 'POST');
$router->add('admin/circuit_trip_create', ['controller' => 'Admin', 'action' => 'getCircuitTripCreate'], 'POST');
$router->add('admin/circuit_trip_update_modal', ['controller' => 'Admin', 'action' => 'getCircuitTripUpdateModal'], 'POST');
$router->add('admin/circuit_trip', ['controller' => 'Admin', 'action' => 'getCircuitTripUpdate'], 'PATCH');

$router->add('admin/circuit_update', ['controller' => 'Admin', 'action' => 'circuitUpdateIndex'], 'POST');
$router->add('admin/circuit_update_simple', ['controller' => 'Admin', 'action' => 'circuitsUpdateSimple'], 'POST');

$router->add('admin/circuits', ['controller' => 'Admin', 'action' => 'circuitsIndex']);
$router->add('admin/circuits/activity_create', ['controller' => 'Admin', 'action' => 'circuitsActivityCreate'], 'POST');
$router->add('admin/circuits/addstep_link', ['controller' => 'Admin', 'action' => 'circuitsAddStepLink'], 'POST');
$router->add('admin/circuits/addstep_tab', ['controller' => 'Admin', 'action' => 'circuitsAddStepTab']);
$router->add('admin/circuits/create_save', ['controller' => 'Admin', 'action' => 'circuitsCreate']);
$router->add('admin/circuits/create', ['controller' => 'Admin', 'action' => 'circuitsCreateIndex']);
$router->add('admin/circuits/organize', ['controller' => 'Admin', 'action' => 'circuitsOrganize']);

$router->add('admin/delete_circuit', ['controller' => 'Admin', 'action' => 'deleteCircuit'], 'POST');
$router->add('admin/delete_circuit_trip', ['controller' => 'Admin', 'action' => 'deleteCircuitTrip'], 'POST');

$router->add('admin/media', ['controller' => 'Medias', 'action' => 'index']);
$router->add('admin/media', ['controller' => 'Medias', 'action' => 'upload'], 'POST');

$router->add('admin/login', ['controller' => 'Employees', 'action' => 'showLogin'], 'GET');
$router->add('admin/login', ['controller' => 'Employees', 'action' => 'login'], 'POST');
$router->add('admin/login', ['controller' => 'Employees', 'action' => 'logout'], 'DELETE');

$router->add('/admin/promotions', ['controller' => 'Promotions', 'action' => 'indexCurrent']);
$router->add('/admin/promotions/all', ['controller' => 'Promotions', 'action' => 'index']);
$router->add('/admin/promotions/application', ['controller' => 'Promotions', 'action' => 'getApplication'], 'POST');
$router->add('/admin/promotions/createApplication', ['controller' => 'Promotions', 'action' => 'updatePromotionCircuits'], 'POST');
$router->add('/admin/promotions/createPromo', ['controller' => 'Promotions', 'action' => 'create'], 'POST');
$router->add('/admin/promotions/deactivate', ['controller' => 'Promotions', 'action' => 'deactivate'], 'POST');
$router->add('/admin/promotions/emptyModal', ['controller' => 'Promotions', 'action' => 'emptyModal']);
$router->add('/admin/promotions/id', ['controller' => 'Promotions', 'action' => 'indexId'], 'POST');
$router->add('/admin/promotions/idModal', ['controller' => 'Promotions', 'action' => 'indexIdModal'], 'POST');
$router->add('/admin/promotions/updatePromo', ['controller' => 'Promotions', 'action' => 'update'], 'POST');


/* CUSTOMER PAGES */

$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('register', ['controller' => 'Members', 'action' => 'create'], 'POST');
$router->add('login', ['controller' => 'Members', 'action' => 'login'], 'POST');
$router->add('login', ['controller' => 'Members', 'action' => 'logout'], 'DELETE');
$router->add('login/facebook', ['controller' => 'Members', 'action' => 'facebookLogin'], 'POST');
$router->add('login/google', ['controller' => 'Members', 'action' => 'googleLogin'], 'POST');


/* SUPPORT CHAT */
// Customer side
$router->add('chat', ['controller' => 'SupportChats', 'action' => 'sendMessage'], 'POST');
$router->add('chat/join', ['controller' => 'SupportChats', 'action' => 'join'], 'POST');
$router->add('chat/leave/{roomid:/\d+/}', ['controller' => 'SupportChats', 'action' => 'leave'], 'DELETE');
$router->add('chat/messages/{roomid:/\d+/}/{index:/\d+/}', ['controller' => 'SupportChats', 'action' => 'getMessageAt'], 'GET');
$router->add('chat/messages/{roomid:/\d+/}/check', ['controller' => 'SupportChats', 'action' => 'checkMessages'], 'GET');
$router->add('chat/messages/{roomid:/\d+/}/all', ['controller' => 'SupportChats', 'action' => 'getAllMessages'], 'GET');
$router->add('chat/rooms', ['controller' => 'SupportChats', 'action' => 'getAllRooms'], 'GET');

// Admin side
$router->add('admin/chat', ['controller' => 'SupportChatAdmin', 'action' => 'sendMessage'], 'POST');
$router->add('admin/chat/join', ['controller' => 'SupportChatAdmin', 'action' => 'join'], 'POST');
$router->add('admin/chat/leave/{roomid:/\d+/}', ['controller' => 'SupportChatAdmin', 'action' => 'leave'], 'DELETE');
$router->add('admin/chat/messages/{roomid:/\d+/}/{index:/\d+/}', ['controller' => 'SupportChatAdmin', 'action' => 'getMessageAt'], 'GET');
$router->add('admin/chat/messages/{roomid:/\d+/}/check', ['controller' => 'SupportChatAdmin', 'action' => 'checkMessages'], 'GET');
$router->add('admin/chat/messages/{roomid:/\d+/}/all', ['controller' => 'SupportChatAdmin', 'action' => 'getAllMessages'], 'GET');
$router->add('admin/chat/rooms', ['controller' => 'SupportChatAdmin', 'action' => 'getAllRooms'], 'GET');


// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
