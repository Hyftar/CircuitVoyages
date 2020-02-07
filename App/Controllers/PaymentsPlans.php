<?php

namespace App\Controllers;

use Core\Controller;
use \Core\View;
use \App\Models\PaymentPlan;
use phpDocumentor\Reflection\Types\Array_;

class PaymentsPlans extends Controller
{

    public function getPaymentsPlansTripAction(){
        $circuit_trip = PaymentPlan::getTripCircuitTrip($_SESSION['trip']);
        $plans = PaymentPlan::getAllPaymentsPlans($circuit_trip['circuit_trip_id']);
        $payments = [];
        foreach ($plans as $plan){
            $paymentsPlan = [];
            $paymentsPlan['plan'] = ['paymentPlanId' => $plan['id'], 'name' => $plan['name']];
            $count = PaymentPlan::countTravelers($_SESSION['trip']);
            $details = PaymentPlan::getPaymentPlanDetails($plan['id'], $count);
            foreach ($details as $detail){
                $paymentsPlan['payments'][] = [
                    'id' => $detail['id'],
                    'amount_due' => $detail['amount_due'],
                    'total_line' => $detail['total_line'],
                    'date_due' => $detail['date_due']
                ];
            }
            $payments[$plan['id']] = $paymentsPlan;
        }
        View::renderTemplate(
            'PaymentsPlans/listPaymentsPlans.html.twig',
            [
                'payments' => $payments
            ]
        );
    }

    public function createOrderAction(){
        $paymentPlan = $_POST['id'];
        $trip_id = $_SESSION['trip'];
        PaymentPlan::choosePaymentPlan($trip_id, $paymentPlan);
    }

}
