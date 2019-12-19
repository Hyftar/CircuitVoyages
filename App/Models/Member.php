<?php

namespace App\Models;

use App\Helpers\LoginHelpers;
use PDO;

class Member extends \Core\Model
{
    public static function createMember(
        $email,
        $password,
        $first_name,
        $last_name,
        $phone_number,
        $date_of_birth,
        $country,
        $city,
        $region,
        $address_line_1,
        $address_line_2,
        $postal_code
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->query('SELECT id FROM languages WHERE name = \'FRENCH\' LIMIT 1');
        $stmt->execute();
        $language_id = $stmt->fetch()['id'];

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

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $address_id = $db->lastInsertId();

        $stmt = $db->prepare(
            'INSERT INTO passwords(password_salt, password_hash)
             VALUES (:password_salt, :password_hash)'
        );

        $salt = LoginHelpers::generateRandomSalt();
        $hash = LoginHelpers::encryptPassword($password, $salt);

        $stmt->bindValue(':password_salt', $salt, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $hash, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $password_id = $db->lastInsertId();

        $stmt = $db->prepare(
            'INSERT INTO members(
                email,
                password_id,
                address_id,
                language_id,
                first_name,
                last_name,
                phone_number,
                date_of_birth
            ) VALUES (
                :email,
                :password_id,
                :address_id,
                :language_id,
                :first_name,
                :last_name,
                :phone_number,
                :dob
            )'
        );

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password_id', $password_id, PDO::PARAM_INT);
        $stmt->bindValue(':address_id', $address_id, PDO::PARAM_INT);
        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindValue(':dob', $date_of_birth, PDO::PARAM_STR);
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();
    }

    public static function createMemberForFacebook($id, $first_name, $last_name)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'INSERT INTO members(first_name, last_name, facebook_id)
             VALUES (:first_name, :last_name, :facebook_id)'
        );

        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':facebook_id', $id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function facebookIdExists($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT * FROM members
             WHERE facebook_id = :facebook_id
             LIMIT 1'
        );

        $stmt->bindValue('facebook_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function exists($email)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT id FROM members
             WHERE email = :email
             LIMIT 1'
        );

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public static function isCorrectPassword($email, $password)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                passwords.id,
                passwords.password_hash,
                passwords.password_salt
             FROM members
             INNER JOIN passwords ON passwords.id = members.password_id
             WHERE email = :email
             LIMIT 1'
        );

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result === false) {
            return false;
        }

        list($id, $password_hash, $password_salt) = $result;

        $hash = LoginHelpers::encryptPassword($password, $password_salt);

        return $hash === $password_hash;
    }

    public static function getByEmail($email)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM members WHERE email = :email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}
