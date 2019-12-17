<?php

namespace App\Models;

use App\Helpers\LoginHelpers;
use Core\Model;
use PDO;

class Accommodation extends Model
{
    public static function getAccommodationTypes()
    {
        $stmt =
            static::getDB()
                ->query(
                    "SHOW COLUMNS
                     FROM accommodations
                     WHERE Field = 'accommodation_type'"
                );
        $stmt->execute();
        preg_match("/^enum\(\'(.*)\'\)$/", $stmt->fetch()['Type'], $matches);
        return explode("','", $matches[1]);
    }

    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query(
            'SELECT
                name,
                accommodation_type,
                rating,
                link
             FROM accommodations
             JOIN locations ON locations.id = location_id
             JOIN addresses ON locations.address_id = addresses.id'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function create($name, $type, $email, $phone, $rating, $region, $city, $country, $address_line_1, $address_line_2, $postal_code, $link)
    {
        $db = static::getDB();
        $db->beginTransaction();
        try {
            $stmt = $db->prepare(
                "INSERT INTO addresses (
                       country,
                       city,
                       region,
                       address_line_1,
                       address_line_2,
                       postal_code)
                 VALUES (:country,
                        :city,
                        :region,
                        :address_line_1,
                        :address_line_2,
                        :postal_code)"
            );

            $stmt->bindValue(':country', $country, PDO::PARAM_STR);
            $stmt->bindValue(':city', $city, PDO::PARAM_STR);
            $stmt->bindValue(':region', $region, PDO::PARAM_STR);
            $stmt->bindValue(':address_line_1', $address_line_1, PDO::PARAM_STR);
            $stmt->bindValue(':address_line_2', $address_line_2, PDO::PARAM_STR);
            $stmt->bindValue(':postal_code', $postal_code, PDO::PARAM_STR);

            $stmt->execute();

            $address_id = $db->lastInsertId();

            $stmt = $db->prepare(
                'INSERT INTO locations(
                     address_id,
                     email,
                     phone_number
                 ) VALUES (
                     :address_id,
                     :email,
                     :phone_number
                 )'
            );

            $stmt->bindValue(':address_id', $address_id, PDO::PARAM_INT);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':phone_number', $phone);

            $stmt->execute();

            $location_id = $db->lastInsertId();

            $stmt = $db->prepare(
                'INSERT INTO accommodations(
                    accommodation_type,
                    location_id,
                    link,
                    rating,
                    name)
                VALUES (
                    :type,
                    :location_id,
                    :link,
                    :rating,
                    :name
                )'
            );

            $stmt->bindValue(':type', $type, PDO::PARAM_INT);
            $stmt->bindValue(':link', $link, PDO::PARAM_STR);
            $stmt->bindValue(':rating', $rating);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);

            $stmt->execute();
        } catch (\Throwable $e) {
            $db->rollBack();
        }

        $db->commit();
    }
}
