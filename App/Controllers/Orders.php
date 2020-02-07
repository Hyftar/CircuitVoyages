<?php


namespace App\Controllers;

use App\Models\CircuitTrip;
use App\Models\Traveler;
use App\Models\Trip;
use Core\View;
use \Core\Views;

class Orders extends \Core\Controller
{
    public function indexAction() {
        $circuit_trip = CircuitTrip::getCircuitTrip($_POST['id']);
        $_SESSION['trip'] = Trip::createTrip($_SESSION['member'][0], $_POST['id'], $circuit_trip['departure_date'], $circuit_trip['departure_date']);
        /*View::renderTemplate('Orders/order_index.html.twig',
            [
                'circuit_trip' => $circuit_trip
            ]); */
    }
}
