<?php


namespace App\Models;

use PDO;

class Trip extends \Core\Model
{
    public static function createTrip($member_id,
        $circuit_trip_id,
        $departure_date,
        $return_date){

        $db = static::getDB();
        $stmt = $db->prepare(
            'INSERT INTO trips(
                member_id,
                circuit_trip_id,
                departure_date,
                return_date
            ) VALUES (
                :member_id,
                :circuit_trip_id,
                :departure_date,
                :return_date
            )'
        );

        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->bindValue(':departure_date', $departure_date, PDO::PARAM_STR);
        $stmt->bindValue(':return_date', $return_date, PDO::PARAM_STR);

        $stmt->execute();
        return $db->lastInsertId();
    }


}
