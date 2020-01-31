<?php

namespace App\Helpers;

use App\Config;




class LoginHelpers
{
    private static $password_patterns = [
        ['pattern' => '/(?=.*[a-z])/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère alphanumérique minuscule'],
        ['pattern' => '/(?=.*[A-Z])/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère alphanumérique majuscule'],
        ['pattern' => '/(?=.*\d)/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère numérique'],
        ['pattern' => '/(?=.*[!@#\$%\^&])/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère parmis !, @, #, $, %, ^ et &'],
        ['pattern' => '/(?=.{8,})/', 'message' => 'Le mot de passe doit contenir au moins 8 caractères']
    ];

    private static $postal_code_pattern = '/^([ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z])[ -]?(\d[ABCEGHJ-NPRSTV-Z]\d)$/i';

    private static $phone_number_pattern = '/^(?<country_code>\+\d{1})?[\s\.\-]?(?<phone>\(?\d{3}\)?[\s\.\-]?\d{3}[\s\-\.]?\d{4})$/';

    public static function encryptPassword($clear_password, $salt)
    {
        return hash('sha256', Config::PEPPER . $clear_password . $salt);
    }

    public static function generateRandomSalt()
    {
        return hash('sha256', bin2hex(random_bytes(64)));
    }

    public static function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword($password)
    {
        $errors = [];
        foreach (static::$password_patterns as $pair) {
            if (!preg_match($pair['pattern'], $password)) {
                $errors[] = $translator->trans($pair['message']);
            }
        }

        return $errors;
    }

    public static function validatePhoneNumber($phone_number)
    {
        $errors = [];
        if (!preg_match(static::$phone_number_pattern, $phone_number, $matches)) {
            $errors[] = $translator->trans('Helpers.Phone');
        }

        return $errors;
    }

    public static function validatePostalCode($postal_code)
    {
        if (!preg_match(static::$postal_code_pattern, $postal_code, $matches, PREG_UNMATCHED_AS_NULL)) {
            return [null, $translator->trans('Helpers.Postal')];
        }

        return [$matches[1] . $matches[2], ''];
    }

    public static function comparePassword($password, $id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                passwords.id,
                passwords.password_hash,
                passwords.password_salt
             FROM members
             INNER JOIN passwords ON passwords.id = members.password_id
             WHERE members.id = :id
             LIMIT 1'
        );

        $stmt->bindvalue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result === false) {
            return false;
        }

        list($id, $password_hash, $password_salt) = $result;

        $hash = encryptPassword($password, $password_salt);

        return $hash === $password_hash;
    }
}
