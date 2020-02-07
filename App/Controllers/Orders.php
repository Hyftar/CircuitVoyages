<?php


namespace App\Controllers;

use App\Models\Circuit;
use App\Models\CircuitTrip;
use Core\View;
use \Core\Views;
use SebastianBergmann\CodeCoverage\TestFixture\C;

class Orders extends \Core\Controller
{
    public function indexAction() {
        $circuit = Circuit::getCircuit($_POST['id']);
        $circuit_trip = CircuitTrip::getCircuitTrip($_POST['id']);
        $steps = Circuit::getStepsForCircuit($_POST['id']);
        $periods = [];
        foreach ($steps as $step) {
            $periodes = Circuit::getPeriodsForStep($step[0]);
            foreach ($periodes as $periode){
                array_push($periods, $periode);
            }
        }
        $accommodations = [];
        foreach ($periods as $period) {
            $hebergements = Circuit::getAccommodationsForPeriod($period[0]);
            foreach ($hebergements as $hebergement){
                array_push($accommodations, $hebergement);
            }
        }
        View::renderTemplate('Orders/order_index.html.twig',
            [
                'circuit_trip' => $circuit_trip,
                'steps' => $steps,
                'periods' => $periods,
                'accommodations' => $accommodations,
                'circuit' => $circuit
            ]);
    }

    public function createRoomsAction() {
        $period_accs = $_POST['period_accs'];
        $circuit_trip_id = $_POST['circuit_trip_id'];
        foreach ($period_accs as $key => $value){

        }

    }
}
