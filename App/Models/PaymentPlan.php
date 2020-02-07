<?php


namespace App\Models;

use PDO;

class PaymentPlan extends \Core\Model
{

    public static function getTripCircuitTrip($trip_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            circuit_trip_id
            FROM trips
            WHERE id = :trip_id');
        $stmt->bindValue(':trip_id',$trip_id, PDO::PARAM_INT);
        $stmt-> execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllPaymentsPlans($circuit_trip_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            id, name
            FROM payments_plans
            WHERE circuit_trip_id = :circuit_trip_id');
        $stmt->bindValue(':circuit_trip_id',$circuit_trip_id, PDO::PARAM_INT);
        $stmt-> execute();
        return $stmt->fetchAll();
    }

    public static function getPaymentPlanDetails($payment_plan_id, $count){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            id, amount_due, amount_due * :nb AS total_line, date_due
            FROM payments
            WHERE payment_plan_id = :payment_plan_id');
        $stmt->bindValue(':payment_plan_id',$payment_plan_id, PDO::PARAM_INT);
        $stmt->bindValue(':nb',$count, PDO::PARAM_INT);
        $stmt-> execute();
        return $stmt->fetchAll();
    }

    public static function choosePaymentPlan($trip_id, $payment_plan_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            id, amount_due, date_due
            FROM payments
            WHERE payment_plan_id = :payment_plan_id');
        $stmt->bindValue(':payment_plan_id',$payment_plan_id, PDO::PARAM_INT);
        $stmt-> execute();
        $listPayments = $stmt->fetchAll();
        $count = self::countTravelers($trip_id);
        foreach ($listPayments as $payment){
            self::insertPaymentPlan($trip_id, $payment_plan_id, $payment['amount_due'], $payment['date_due'], $count);
        }
    }

    public static function countTravelers($trip_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            COUNT(id)
            FROM travelers
            WHERE trip_id = :trip_id');
        $stmt->bindValue(':trip_id',$trip_id, PDO::PARAM_INT);
        $stmt-> execute();
        return $stmt->fetchColumn();
    }

    public static function insertPaymentPlan($trip_id, $payment_plan_id, $amount_due, $date_due, $count){
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO trips_payments (
            trip_id,
            payment_plan_id,
            amount_due,
            date_due,
            transaction_id)
            VALUES(
                :trip_id,
                :payment_plan_id,
                :amount_due * :travelersCount,
                :date_due,
                NULL)');
        $stmt->bindValue(':trip_id',$trip_id, PDO::PARAM_INT);
        $stmt->bindValue(':payment_plan_id',$payment_plan_id, PDO::PARAM_INT);
        $stmt->bindValue(':amount_due',$amount_due, PDO::PARAM_INT);
        $stmt->bindValue(':date_due',$date_due, PDO::PARAM_STR);
        $stmt->bindValue(':travelersCount', $count, PDO::PARAM_INT);
        $stmt-> execute();
    }

}
