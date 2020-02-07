<?php

namespace App\Models;

use Core\Model;
use PDO;

class TripPayment extends Model
{
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
            'SELECT amount_due
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
