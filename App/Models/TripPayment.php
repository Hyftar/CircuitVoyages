<?php

namespace App\Models;

use Core\Model;
use PDO;

class TripPayment extends Model
{
    public static function addTransaction($tpid, $payer_id, $amount, $order_id)
    {

        $db = static::getDB();
        $db->beginTransaction();
        $stmt = $db->prepare(
            "INSERT INTO transactions
                (currency_code, gross_amount, transaction_order, payer_order, status)
            VALUES ('CAD', :amount, :order_id, :payer_id, 1)"
        );

        $stmt->bindValue(':amount', $amount);
        $stmt->bindValue(':order_id', $order_id);
        $stmt->bindValue(':payer_id', $payer_id);

        $stmt->execute();

        $transaction_id = $db->lastInsertId();

        $db = static::getDB();
        $stmt = $db->prepare(
            "UPDATE trips_payments
            SET transaction_id = :transaction_id
            WHERE id = :tpid"
        );

        $stmt->bindValue(':tpid', $tpid);
        $stmt->bindValue(':transaction_id', $transaction_id);
        $stmt->execute();

        $db->commit();
    }

    public static function getFullUnpaidBalance($trip_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT SUM(amount_due) AS amount
             FROM trips_payments
             WHERE
                trip_id = :trip_id
                AND transaction_id IS null
                AND date_due < NOW();'
        );

        $stmt->bindValue(':trip_id', $trip_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getPaymentAmount($trips_payments_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT amount_due AS amount
             FROM trips_payments
             WHERE
                id = :id
                AND transaction_id IS NULL'
        );

        $stmt->bindValue(':id', $trips_payments_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
