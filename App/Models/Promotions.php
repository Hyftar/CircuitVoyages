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
}
