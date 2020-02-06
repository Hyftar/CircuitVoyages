<?php


namespace App\Controllers;

use App\Models\CircuitTrip;
use Core\View;
use \Core\Views;

class Orders extends \Core\Controller
{
    public function indexAction() {
        $circuit_trip = CircuitTrip::getCircuitTrip($_POST['id']);
        View::renderTemplate('Orders/order_index.html.twig',
            [
                'circuit_trip' => $circuit_trip
            ]);
    }
}
