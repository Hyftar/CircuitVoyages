<?php

namespace App\Helpers;

class LoginHelpers
{
    private static $password_patterns = [
        ['pattern' => '/(?=.*[a-z])/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère alphanumérique minuscule'],
        ['pattern' => '/(?=.*[A-Z])/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère alphanumérique majuscule'],
        ['pattern' => '/(?=.*\d)/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère numérique'],
        ['pattern' => '/(?=.*[!@#\$%\^&])/', 'message' => 'Le mot de passe doit contenir au moins 1 caractère parmis !, @, #, $, %, ^ et &'],
        ['pattern' => '/(?=.{8,})/', 'message' => 'Le mot de passe doit contenir au moins 8 caractères']
    ];

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
                $errors[] = $pair['message'];
            }
        }

        return $errors;
    }
}
