<?php

namespace App\Models;

use App\Helpers\LoginHelpers;
use Core\Model;
use PDO;

class Employee extends Model
{
    public static function createEmployee(
        $email,
        $first_name,
        $last_name,
        $phone_number,
        $date_of_birth,
        $languages
    )
    {
        $db = static::getDB();
        $db->beginTransaction();
        try {
            $stmt = $db->prepare(
                'INSERT INTO employees(
                          first_name,
                          last_name,
                          date_of_birth,
                          active,
                          phone_number,
                          email)
                      VALUES (
                          :first_name,
                          :last_name,
                          :dob,
                          1,
                          :phone_number,
                          :email
                      )'
            );

            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);
            $stmt->bindValue(':dob', $date_of_birth, PDO::PARAM_STR);

            $stmt->execute();

            $employee_id = $db->lastInsertId();
            foreach ($languages as $language_id) {
                $stmt = $db->prepare(
                    'INSERT INTO employees_languages
                        (language_id, employee_id)
                    VALUES
                        (:language_id, :employee_id)'
                );

                $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
                $stmt->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        catch (\Throwable $e) {
            error_log($e);
            $db->rollBack();
            return;
        }

        $db->commit();
    }

    public static function createEmployeeWithPassword(
        $email,
        $first_name,
        $last_name,
        $phone_number,
        $date_of_birth,
        $password,
        $languages
    )
    {
        $db = static::getDB();
        $db->beginTransaction();
        try {
            $stmt = $db->prepare(
                'INSERT INTO passwords(password_salt, password_hash)
             VALUES (:password_salt, :password_hash)'
            );

            $salt = LoginHelpers::generateRandomSalt();
            $hash = LoginHelpers::encryptPassword($password, $salt);

            $stmt->bindValue(':password_salt', $salt, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $hash, PDO::PARAM_STR);

            $stmt->execute();

            $password_id = $db->lastInsertId();

            $stmt = $db->prepare(
                'INSERT INTO employees(
                          first_name,
                          last_name,
                          date_of_birth,
                          active,
                          phone_number,
                          email,
                          password_id
                      )
                      VALUES (
                          :first_name,
                          :last_name,
                          :dob,
                          1,
                          :phone_number,
                          :email,
                          :password_id
                      )'
            );

            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);
            $stmt->bindValue(':dob', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindValue(':password_id', $password_id, PDO::PARAM_INT);

            $stmt->execute();

            $employee_id = $db->lastInsertId();

            foreach ($languages as $language_id) {
                $stmt = $db->prepare(
                    'INSERT INTO employees_languages
                        (language_id, employee_id)
                    VALUES
                        (:language_id, :employee_id)'
                );

                $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
                $stmt->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
        catch (\Throwable $e) {
            error_log($e);
            $db->rollBack();
            return;
        }

        $db->commit();
    }

    public static function exists($email)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT id FROM employees
             WHERE email = :email
             LIMIT 1'
        );

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch() !== false;
    }

    public static function getByEmail($email)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                id,
                first_name,
                last_name,
                date_of_birth,
                active,
                media_id,
                phone_number,
                email,
                role_id,
                password_id
            FROM employees
            WHERE email = :email'
        );
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function isCorrectPassword($email, $password)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT
                passwords.id,
                passwords.password_hash,
                passwords.password_salt
             FROM employees
             INNER JOIN passwords ON passwords.id = employees.password_id
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

        return $password_hash === $hash;
    }
}
