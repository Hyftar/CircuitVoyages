<?php

namespace App\Models;

use PDO;

class Member extends \Core\Model
{
    // CREATE TABLE `members` (
    //   `id` int(11) NOT NULL,
    //   `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
    //   `password_id` int(11) DEFAULT NULL,
    //   `address_id` int(11) NOT NULL,
    //   `language_id` int(11) NOT NULL,
    //   `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
    //   `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
    //   `phone_number` varchar(15) COLLATE utf8mb4_bin NOT NULL,
    //   `date_of_birth` date NOT NULL,
    //   `facebook_id` bigint(20) UNSIGNED DEFAULT NULL
    // ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

    public static function createMember(
        $email,
        $password,
        $first_name,
        $last_name,
        $phone_number,
        $date_of_birth,
        $address
    )
    {
        $db = static::getDB();

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

        $hash = LoginHelper::encryptPassword($password, $password_salt);

        $stmt = $db->prepare(
            'SELECT id FROM passwords
             WHERE id = :id AND password_hash = :hash
             LIMIT 1'
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':hash', $hash, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }
}
