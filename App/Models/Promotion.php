<?php

namespace app\Models;

use PDO;

class Promotions extends \Core\Model
{
    // get all promotions
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions');
        $stmt-> execute();
        return $stmt->fetchAll();
    }

    // get specific promotion
    public static function get($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions WHERE $id = :id');
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // insert new promotion
    public static function add($start_date, $end_date, $promotion_type_id, $promo_code, $value, $description, $availability_number)
    {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO promotions(start_date,end_date, promotion_type_id, promo_code, value, description, availability_number)
        VALUES (:start_date, :end_date, :promotion_type_id, :promo_code, :value, :description, :availability_number)');
        $stmt->bindValue(':start_date',$start_date, PDO::PARAM_STR);
        $stmt->bindValue(':end_date',$end_date, PDO::PARAM_STR);
        $stmt->bindValue(':promotion_type_id',$promotion_type_id, PDO::PARAM_INT);
        $stmt->bindValue(':promo_code',$promo_code, PDO::PARAM_STR);
        $stmt->bindValue(':value',$value, PDO::PARAM_STR);
        $stmt->bindValue(':description',$description, PDO::PARAM_STR);
        $stmt->bindValue(':availability_number',$availability_number, PDO::PARAM_STR);
        return $stmt->execute();
    }

    //  update information of promotions
    public static function update($id, $start_date, $end_date, $promotion_type_id, $promo_code, $value, $description, $availability_number)
    {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE promotions SET
            start_date = :start_date,
            end_date = :end_date,
            promotion_type_id = :promotion_type_id,
            promo_code = :promo_code,
            value = :value,
            description = :description,
            availability_number = :availability_number
            WHERE id = :id');
        $stmt->bindValue(':start_date',$start_date, PDO::PARAM_STR);
        $stmt->bindValue(':end_date',$end_date, PDO::PARAM_STR);
        $stmt->bindValue(':promotion_type_id',$promotion_type_id, PDO::PARAM_INT);
        $stmt->bindValue(':promo_code',$promo_code, PDO::PARAM_STR);
        $stmt->bindValue(':value',$value, PDO::PARAM_STR);
        $stmt->bindValue(':description',$description, PDO::PARAM_STR);
        $stmt->bindValue(':availability_number',$availability_number, PDO::PARAM_STR);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Remeve promotion from database
    public static function remove($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM genres WHERE id=:id');
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        return $stmt->execute() != false;
    }

    // Generate random unique promo code for use in promotion redemption
    public static function generatePromoCode($code_length)
    {
        $resultat = '';
        $promo_code = '';

        $code_length > 1 ? $length = $code_length - 1 : $length = 0;

        do
        {
            // La chaîne de caractères possibles n'inclut pas de voyelles, afin d'empêcher de former des mots, et le 1 et le 0 afin d'éviter la confusion
            $possible_characters = '23456789qwrtpsdfghjklzxcvbnm';
            $promo_code = '';
            $characters_length = strlen($possible_characters);
            $string = '';
            for ($i = 0; $i < $length; $i++) {
                $string .= $possible_characters[mt_rand(0, $characters_length - 1)];
            }

            $db = static::getDB();
            $stmt = $db->prepare('SELECT * FROM promotions WHERE promo_code = :promo_code');
            $stmt->bindValue(':promo_code',$promo_code, PDO::PARAM_STR);
            $stmt->execute();
            $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        while (!$resultat);
        return $promo_code;
    }

    // get all promotions_types
    public static function getAllTypes()
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions_types');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // set promotion on all circuits_trips of all circuits
    public static function addPromotionToAllCircuits($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM circuits_trips');
        $stmt->execute();
        $circuits_trips = $stmt->fetchAll();

        foreach($circuits_trips as $circuit_trip){
            $stmtI = $db->prepare('INSERT INTO promotions_circuits_trips (promotion_id, circuit_trip_id)
            VALUES (:id, :circuit_trip_id)');
            $stmtI->bindValue(':circuit_trip_id',$circuit_trip['id'], PDO::PARAM_INT);
            $stmtI->bindValue(':id',$id, PDO::PARAM_INT);
            $stmtI->execute();
        }
    }

    // set promotion on all circuits_trips of circuit
    public static function addPromotionToOneCircuit($id,$circuit_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM circuits_trips WHERE id = :id');
        $stmt->bindValue(':id',$circuit_id,PDO::PARAM_INT);
        $stmt->execute();
        $circuits_trips = $stmt->fetchAll();

        foreach($circuits_trips as $circuit_trip){
            $stmtI = $db->prepare('INSERT INTO promotions_circuits_trips (promotion_id, circuit_trip_id)
            VALUES (:id, :circuit_trip_id)');
            $stmtI->bindValue(':circuit_trip_id',$circuit_trip['id'], PDO::PARAM_INT);
            $stmtI->bindValue(':id',$id, PDO::PARAM_INT);
            $stmtI->execute();
        }
    }

    // set promotion on specific circuit_trip
    public static function addPromotionToOneCircuitTrip($id,$circuit_trip_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('INSERT INTO promotions_circuits_trips (promotion_id, circuit_trip_id)
        VALUES (:id, :circuit_trip_id)');
        $stmt->bindValue(':circuit_trip_id',$circuit_trip_id, PDO::PARAM_INT);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // check if member has already used the promotion code
    public static function isPromotionUsed($id, $member_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions_trip_members WHERE promotion_id = :id and member_id = :member_id');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->bindValue(':member_id',$member_id,PDO::PARAM_INT);
        $stmt->execute();
        $promotion_trip_circuit = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$promotion_trip_circuit) {
            return false;
        }
        else {
            return $promotion_trip_circuit['applied'];
        }
    }

    // check if promotion is still available
    public static function promotionAvailability($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions WHERE id = :id and CURDATE() BETWEEN start_date and end_date');
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        $promotion = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$promotion) {
            return false;
        }
        elseif ($promotion['availability_number'] == -1) {
            return true;
        }
        else {
            $stmtCount = $db->prepare('SELECT COUNT(*) FROM promotions_trips_members WHERE promotion_id = :id');
            $stmtCount->bindValue(':id',$id);
            $stmtCount->execute();
            $number_rows = $stmtCount->fetchColumn();
            $promotion['availability_number'] > $number_rows ? $reponse = true: $reponse = false;
            return $reponse;
        }
    }

    // register use of the promotion by a member
    public static function recordPromotionUse($id, $trip_id, $member_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions_trip_members WHERE promotion_id = :id and trip_id = :trip_id');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->bindValue(':trip_id',$trip_id,PDO::PARAM_INT);
        $stmt->execute();
        $promotion_trip_circuit = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$promotion_trip_circuit)
        {
            $stmtI = $db->prepare('INSERT INTO promotions_trips_members (promotion_id, member_id, trip_id, promotion_code, applied)
            VALUES (:id, :member_id, :trip_id, null, true)');
            $stmtI->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtI->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $stmtI->bindValue(':trip_id',$trip_id,PDO::PARAM_INT);
            $stmtI->execute();
        }
        else
        {
            $stmtI = $db->prepare('UPDATE promotions_trips_members SET applied = true WHERE id = :id');
            $stmtI->bindValue(':id', $promotion_trip_circuit['id'], PDO::PARAM_INT);
            $stmtI->execute();
        }
    }

    // Get all members that used the promotion
    public static function getPromotionUsers($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions_trips_members WHERE promotion_id = :id');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
