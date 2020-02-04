<?php

namespace App\Models;

use \App\Helpers\LoginHelpers;
use \Core\Model;
use PDO;

class PasswordReset extends Model
{
    public static function generateToken($email)
    {
        $db = static::getDB();

        $stmt = $db->prepare(
            'SELECT id FROM members WHERE email = :email'
        );

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $fetched_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fetched_data == false) {
            return false;
        }

        $db->beginTransaction();

        $member_id = $fetched_data['id'];
        $token = LoginHelpers::generateRandomSalt();

        $stmt = $db->prepare(
            'INSERT INTO password_reset (member_id, token)
             VALUES (:member_id, :token)'
        );

        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_STR);
        $stmt->execute();

        $db->commit();
        return $token;
    }

    public static function verifyToken($token)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT id FROM password_reset WHERE token = :token');
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) != false;
    }

    public static function deleteTokens($member_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM password_reset WHERE member_id = :member_id');
        $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function getMemberFromToken($token)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT member_id FROM password_reset
             WHERE token = :token'
        );

        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['member_id'];
    }
}
