<?php

namespace app\Models;

use PDO;

class Promotions extends \Core\Model
{
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM promotions');
        $stmt->execute();
        return $stmt->fetchAll();
    }

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

    public static function remove($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM genres WHERE id=:id');
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        return $stmt->execute() != false;
    }

    private static function generatePromoCode($code_length)
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
}
