<?php


namespace App\Models;

use PDO;

class Traveler extends \Core\Model
{
    public static function createTraveler(
        $trip_id,
        $address_id,
        $first_name,
        $last_name,
        $date_of_birth,
        $phone_number,
        $gender,
        $assistance,
        $redress_number
    )
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'INSERT INTO travelers(
                trip_id,
                address_id,
                first_name,
                last_name,
                date_of_birth,
                phone_number,
                gender,
                redress_number,
                needs_special_assistance
            ) VALUES (
                :trip_id,
                :address_id,
                :first_name,
                :last_name,
                :dob,
                :phone_number,
                :gender,
                :redress_number,
                :needs_special_assistance
            )'
        );

        $stmt->bindValue(':trip_id', $trip_id, PDO::PARAM_INT);
        $stmt->bindValue(':address_id', $address_id, PDO::PARAM_STR);
        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':dob', $date_of_birth, PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindValue(':redress_number', $redress_number, PDO::PARAM_STR);
        $stmt->bindValue(':needs_special_assistance', $assistance, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function createTravelerAddress(
        $country,
        $city,
        $region,
        $address_line_1,
        $address_line_2,
        $postal_code
    )
    {
        $db = static::getDB();

        $stmt = $db->prepare(
            'INSERT INTO addresses(
                country,
                city,
                region,
                address_line_1,
                address_line_2,
                postal_code
            ) VALUES (
                :country,
                :city,
                :region,
                :address_line_1,
                :address_line_2,
                :postal_code
            )'
        );

        $stmt->bindValue(':country', $country, PDO::PARAM_STR);
        $stmt->bindValue(':city', $city, PDO::PARAM_STR);
        $stmt->bindValue(':region', $region, PDO::PARAM_STR);
        $stmt->bindValue(':address_line_1', $address_line_1, PDO::PARAM_STR);
        $stmt->bindValue(':address_line_2', $address_line_2, PDO::PARAM_STR);
        $stmt->bindValue(':postal_code', $postal_code, PDO::PARAM_STR);

        $stmt->execute();
        return $db->lastInsertId();
    }

    public static function getTravelers($trip_id){
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT id, first_name, last_name FROM travelers WHERE trip_id = :trip_id'
        );
        $stmt->bindValue(':trip_id', $trip_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function deleteTraveler($id){
        $db = static::getDB();
        $stmt = $db->prepare(
            'DELETE FROM travelers WHERE id = :id'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}
