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
}
