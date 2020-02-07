<?php
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';
use App\Helpers\TranslationHelpers;

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

if (empty($_SESSION['locale'])) {
    $_SESSION['locale'] = 'fr';
}

/**
 * Routing
 */
$router = new Core\Router();

/* ADMIN PAGES */

$router->add('admin', ['controller' => 'Admin', 'action' => 'admin']);
$router->add('admin/index', ['controller' => 'Admin', 'action' => 'index']);

$router->add('admin/accommodation', ['controller' => 'Admin', 'action' => 'accommodationIndex']);
$router->add('admin/accommodation', ['controller' => 'Admin', 'action' => 'accommodationCreate'], 'POST');
$router->add('admin_delete_period', ['controller' => 'Admin', 'action' => 'deletePeriod'], 'POST');
$router->add('admin_accommodation_step_add', ['controller' => 'Admin', 'action' => 'addAccStep'], 'POST');

$router->add('admin/activity', ['controller' => 'Admin', 'action' => 'activityIndex']);
$router->add('admin/activity', ['controller' => 'Admin', 'action' => 'activityCreate'], 'POST');
$router->add('admin_activity_list', ['controller' => 'Admin', 'action' => 'listActivities'], 'POST');
$router->add('admin_activity_add', ['controller' => 'Admin', 'action' => 'addActivity'], 'POST');
$router->add('admin_delete_activity_step', ['controller' => 'Admin', 'action' => 'deleteActivityStep'], 'POST');

$router->add('admin/circuit_create_simple', ['controller' => 'Admin', 'action' => 'circuitsCreateSimple'], 'POST');

$router->add('admin/circuit_trips', ['controller' => 'Admin', 'action' => 'getCircuitTrips'], 'POST');
$router->add('admin/circuit_trip_create_modal', ['controller' => 'Admin', 'action' => 'getCircuitTripCreateModal'], 'POST');
$router->add('admin/circuit_trip_create', ['controller' => 'Admin', 'action' => 'getCircuitTripCreate'], 'POST');
$router->add('admin/circuit_trip_update_modal', ['controller' => 'Admin', 'action' => 'getCircuitTripUpdateModal'], 'POST');
$router->add('admin/circuit_trip', ['controller' => 'Admin', 'action' => 'getCircuitTripUpdate'], 'POST');

$router->add('admin/payments', ['controller' => 'Admin', 'action' => 'payments'], "POST");
$router->add('admin/payment_plans', ['controller' => 'Admin', 'action' => 'paymentPlans'], 'POST');
$router->add('admin/payment_ajout', ['controller' => 'Admin', 'action' => 'paymentAjout'], 'POST');
$router->add('admin/payment_plan_ajout', ['controller' => 'Admin', 'action' => 'paymentPlanAjout'], 'POST');
$router->add('admin/payment_suppression', ['controller' => 'Admin', 'action' => 'paymentSuppression'], 'POST');
$router->add('admin/payment_plan_suppression', ['controller' => 'Admin', 'action' => 'paymentPlanSuppression'], 'POST');

$router->add('admin/circuit_update', ['controller' => 'Admin', 'action' => 'circuitUpdateIndex'], 'POST');
$router->add('admin/circuit_update_simple', ['controller' => 'Admin', 'action' => 'circuitsUpdateSimple'], 'POST');

$router->add('admin/circuits', ['controller' => 'Admin', 'action' => 'circuitsIndex']);
$router->add('admin/circuits/create', ['controller' => 'Admin', 'action' => 'circuitsCreateIndex']);

$router->add('admin/delete_circuit', ['controller' => 'Admin', 'action' => 'deleteCircuit'], 'POST');
$router->add('admin/delete_circuit_trip', ['controller' => 'Admin', 'action' => 'deleteCircuitTrip'], 'POST');

$router->add('admin_circuits_etapes', ['controller' => 'Admin', 'action' => 'etapesIndex'], 'POST');
$router->add('admin_creation_etape_simple', ['controller' => 'Admin', 'action' => 'etapesCreateIndex'], 'POST');
$router->add('admin_etape_simple_create', ['controller' => 'Admin', 'action' => 'etapesCreate'], 'POST');
$router->add('admin_etape_getupdate', ['controller' => 'Admin', 'action' => 'etapeUpdateIndex'], 'POST');
$router->add('admin_etape_update', ['controller' => 'Admin', 'action' => 'etapeUpdate'], 'POST');
$router->add('admin_delete_etape', ['controller' => 'Admin', 'action' => 'etapeDelete'], 'POST');

/* -- ADMIN DEPRECATED -- */
$router->add('admin/circuits/addstep_link', ['controller' => 'Admin', 'action' => 'circuitsAddStepLink'], 'POST');
$router->add('admin/circuits/addstep_tab', ['controller' => 'Admin', 'action' => 'circuitsAddStepTab']);
$router->add('admin/circuits/activity_create', ['controller' => 'Admin', 'action' => 'circuitsActivityCreate'], 'POST');
$router->add('admin/circuits/organize', ['controller' => 'Admin', 'action' => 'circuitsOrganize']);
$router->add('admin/circuits/create_save', ['controller' => 'Admin', 'action' => 'circuitsCreate']);
/* -- END DEPRECATED -- */

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

$router->add('circuit/{id:/\d+/}', ['controller' => 'Circuits', 'action' => 'show']);

$router->add('register', ['controller' => 'Members', 'action' => 'create'], 'POST');
$router->add('login', ['controller' => 'Members', 'action' => 'login'], 'POST');
$router->add('login', ['controller' => 'Members', 'action' => 'logout'], 'DELETE');
$router->add('login/facebook', ['controller' => 'Members', 'action' => 'facebookLogin'], 'POST');
$router->add('login/google', ['controller' => 'Members', 'action' => 'googleLogin'], 'POST');

/* MEMBER ACCOUNT */
$router->add('member',['controller' => 'Members', 'action' => 'show'], 'GET');
$router->add('member/informations',['controller' => 'Members', 'action' => 'showInformations'], 'GET');
$router->add('member/sendInformations',['controller' => 'Members', 'action' => 'sendInformations'], 'POST');
$router->add('member/coordinates',['controller' => 'Members', 'action' => 'showCoordinates'], 'GET');
$router->add('member/sendCoordinates',['controller' => 'Members', 'action' => 'sendCoordinates'], 'POST');
$router->add('member/security',['controller' => 'Members', 'action' => 'showSecurity'], 'GET');
$router->add('member/sendSecurity',['controller' => 'Members', 'action' => 'sendSecurity'], 'POST');
$router->add('member/communications',['controller' => 'Members', 'action' => 'showCommunications'], 'GET');
$router->add('member/sendCommunications',['controller' => 'Members', 'action' => 'sendCommunications'], 'POST');
$router->add('member/trips',['controller' => 'Members', 'action' => 'showTrips'], 'GET');
$router->add('member/tripsUpcoming',['controller' => 'Members', 'action' => 'showTripsUpcoming'], 'GET');
$router->add('member/payments',['controller' => 'Members', 'action' => 'showPaidPayments'], 'GET');
$router->add('member/paymentsUpcoming',['controller' => 'Members', 'action' => 'showUnpaidPayments'], 'GET');
$router->add('member/suscribe',['controller' => 'Members', 'action' => 'suscribe'], 'POST');
$router->add('member/unsuscribe',['controller' => 'Members', 'action' => 'unsuscribe'], 'POST');



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

// Newsletters
$router->add('admin/getNewsletters', ['controller' => 'Newsletters', 'action' => 'getNewsletters'], 'GET');
$router->add('admin/getMessages', ['controller' => 'Newsletters', 'action' => 'getMessages'], 'POST');
$router->add('admin/getNewsletterCreator', ['controller' => 'Newsletters', 'action' => 'getNewsletterCreator'], 'GET');
$router->add('admin/createNewsletter', ['controller' => 'Newsletters', 'action' => 'createNewsletter'], 'POST');
$router->add('admin/getMessageCreator', ['controller' => 'Newsletters', 'action' => 'getMessageCreator'], 'POST');
$router->add('admin/deleteNewsletter', ['controller' => 'Newsletters', 'action' => 'deleteNewsletter'], 'POST');
$router->add('admin/sendMessage', ['controller' => 'Newsletters', 'action' => 'sendMessage'], 'POST');
$router->add('admin/getNewsletterUpdater', ['controller' => 'Newsletters', 'action' => 'getNewsletterUpdater'], 'POST');
$router->add('admin/sendUpdate', ['controller' => 'Newsletters', 'action' => 'saveNewsletterUpdate'], 'POST');

// Order circuit
$router->add('admin/addTraveler', ['controller' => 'Travelers', 'action' => 'addTraveler'], 'POST');
$router->add('admin/getTravelers', ['controller' => 'Travelers', 'action' => 'getTravelers'], 'GET');
$router->add('admin/getTravelerCreator', ['controller' => 'Travelers', 'action' => 'getTravelerCreator'], 'GET');
$router->add('admin/deleteTraveler', ['controller' => 'Travelers', 'action' => 'deleteTraveler'], 'POST');

// Orders
$router->add('/order/index', ['controller' => 'Orders', 'action' => 'index'], 'POST');
$router->add('/order/getPaymentsPlans', ['controller' => 'PaymentsPlans', 'action' => 'getPaymentsPlansTrip'], 'GET');
$router->add('/order/createOrder', ['controller' => 'PaymentsPlans', 'action' => 'createOrder'], 'POST');


// API routes
$router->add('api/getCircuits', ['controller' => 'API', 'action' => 'getCircuits'], 'GET');

// Password reset

$router->add('password_reset', ['controller' => 'ForgotPassword', 'action' => 'showResetPage', 'allowed_variables' => ['token']]);
$router->add('password_reset', ['controller' => 'ForgotPassword', 'action' => 'confirmReset'], 'POST');
$router->add('send_email', ['controller' => 'ForgotPassword', 'action' => 'sendEmail'], 'POST');

$router->add('cartrow', ['controller' => 'CartRenderer', 'action' => 'getCartRow', 'allowed_variables' => ['id', 'name', 'date', 'price']]);

/* Translator */
$router->add('changelocale', ['controller' => 'Translation', 'action' => 'setLocale'], 'POST');

// Send the URI and Method to the dispatcher
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
