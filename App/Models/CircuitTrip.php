<?php

namespace App\Models;

use App\Helpers\LoginHelpers;
use Core\Model;
use PDO;

class CircuitTrip extends Model
{

    public static function getAllFromCircuit($id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT *
            FROM circuits_trips
            WHERE circuit_id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getCircuitTrip($id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT *
            FROM circuits_trips
            WHERE id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function createCircuitTrip($circuit_id,
            $departure_date,
            $price,
            $refund_date,
            $cancellation_date,
            $cancellation_fee,
            $places,
            $quorum,
            $is_public){
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO circuits_trips
            (circuit_id, departure_date, price, refund_date, cancellation_date,
            cancellation_fee, places, quorum, is_public)
            VALUES(:circuit_id, :departure_date, :price, :refund_date, :cancellation_date,
            :cancellation_fee, :places, :quorum, :is_public);');
        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->bindValue(':departure_date', $departure_date, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':refund_date', $refund_date, PDO::PARAM_STR);
        $stmt->bindValue(':cancellation_date', $cancellation_date, PDO::PARAM_STR);
        $stmt->bindValue(':cancellation_fee', $cancellation_fee, PDO::PARAM_STR);
        $stmt->bindValue(':places', $places, PDO::PARAM_INT);
        $stmt->bindValue(':quorum', $quorum, PDO::PARAM_INT);
        $stmt->bindValue(':is_public', $is_public, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateCircuitTrip(
         $id,
         $departure_date,
         $price,
         $refund_date,
         $cancellation_date,
         $cancellation_fee,
         $places,
         $quorum,
         $is_public){
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE circuits_trips SET
            departure_date = :departure_date, price = :price, refund_date = :refund_date,
            cancellation_date = :cancellation_date,
            cancellation_fee = :cancellation_fee, places = :places, quorum = :quorum, is_public = :is_public
            WHERE id = :id;');
        $stmt->bindValue(':departure_date', $departure_date, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':refund_date', $refund_date, PDO::PARAM_STR);
        $stmt->bindValue(':cancellation_date', $cancellation_date, PDO::PARAM_STR);
        $stmt->bindValue(':cancellation_fee', $cancellation_fee, PDO::PARAM_STR);
        $stmt->bindValue(':places', $places, PDO::PARAM_INT);
        $stmt->bindValue(':quorum', $quorum, PDO::PARAM_INT);
        $stmt->bindValue(':is_public', $is_public, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function deleteCircuitTrip($id){
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('DELETE FROM circuits_trips WHERE id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }
        $db->commit();
        return $row;
    }

    public static function getPaymentPlansAll($circuit_trip_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT *
            FROM payments_plans
            WHERE  circuit_trip_id = :circuit_trip_id;');
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPaymentPlan($id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT *
            FROM payments_plans
            WHERE id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getPayments($payment_plan_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT *
            FROM payments
            WHERE payment_plan_id = :payment_plan_id;');
        $stmt->bindValue(':payment_plan_id', $payment_plan_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function createPaymentPlan($circuit_trip_id, $name)
    {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO payments_plans
            (circuit_trip_id, name)
            VALUES(:circuit_trip_id, :name)');
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function createPayment($payment_plan_id, $amount_due, $date_due)
    {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO payments
            (payment_plan_id, amount_due, date_due)
            VALUES(:payment_plan_id, :amount_due, :date_due)');
        $stmt->bindValue(':payment_plan_id', $payment_plan_id, PDO::PARAM_INT);
        $stmt->bindValue(':amount_due', $amount_due, PDO::PARAM_INT);
        $stmt->bindValue(':date_due', $date_due);
        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function deletePaymentPlan($id){
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('DELETE FROM payments_plans WHERE id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }
        $db->commit();
        return $row;
    }

    public static function deletePayment($id){
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('DELETE FROM payments WHERE id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }
        $db->commit();
        return $row;
    }


}
