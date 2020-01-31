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

    public static function createMemberForGoogle($id, $first_name, $last_name, $email)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'INSERT INTO members(first_name, last_name, google_id, email)
             VALUES (:first_name, :last_name, :google_id, :email)'
        );
        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':google_id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
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

    public static function googleIdExists($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT * FROM members
             WHERE google_id = :google_id
             LIMIT 1'
        );
        $stmt->bindValue('google_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
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

    public static function getMemberInformations($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM members WHERE id = :id');
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getMemberNewsletters($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT newsletters.id, newsletters.name, members_newsletters.id AS suscribed
            FROM newsletters LEFT JOIN members_newsletters ON members_newsletters.newsletter_id = newsletters.id AND members_newsletters.member_id = :id');
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getMemberAddress($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT addresses.id, addresses.country, addresses.city,
            addresses.region, addresses.address_line_1, addresses.address_line_2, addresses.postal_code
            FROM addresses INNER JOIN members ON addresses.id = members.address_id WHERE members.id = :id');
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function updateMemberAddress($id, $country, $city, $region, $address_line_1,
                                               $address_line_2, $postal_code)
    {
        $db = static::getDB();

        $stmt = $db->prepare('SELECT * FROM MEMBERS WHERE id = :id AND address_id IS NOT NULL');
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $db->beginTransaction();
            $stmt = $db->prepare(
                'INSERT INTO addresses
                    (country,
                    city,
                    region,
                    address_line_1,
                    address_line_2,
                    postal_code)
                    VALUES
                    (:country,
                    :city,
                    :region,
                    :address_line_1,
                    :address_line_2,
                    :postal_code);'
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
            $rep = $db->lastInsertId();
            $stmt = $db->prepare('UPDATE members
                SET address_id = :rep
                WHERE id = :id');
            $stmt->bindValue(':rep', $rep, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                $db->rollBack();
                return;
            }
            $db->commit();
            return;
        }

        $stmt = $db->prepare('UPDATE addresses
            INNER JOIN members ON addresses.id = members.address_id
            SET country = :country,
            city = :city,
            region = :region,
            address_line_1 = :address_line_1,
            address_line_2 = :address_line_2,
            postal_code = :postal_code
            WHERE members.id = :id;'
        );

        $stmt->bindValue(':country', $country, PDO::PARAM_STR);
        $stmt->bindValue(':city', $city, PDO::PARAM_STR);
        $stmt->bindValue(':region', $region, PDO::PARAM_STR);
        $stmt->bindValue(':address_line_1', $address_line_1, PDO::PARAM_STR);
        $stmt->bindValue(':address_line_2', $address_line_2, PDO::PARAM_STR);
        $stmt->bindValue(':postal_code', $postal_code, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function updateMemberPassword($password, $id)
    {
        $db = static::getDB();

        $stmt = $db->prepare('UPDATE passwords
            INNER JOIN members ON members.password_id = passwords.id
            SET password_salt = :password_salt,
            password_hash = :password_hash
            WHERE members.id = :id;'
        );

        $salt = LoginHelpers::generateRandomSalt();
        $hash = LoginHelpers::encryptPassword($password, $salt);

        $stmt->bindValue(':password_salt', $salt, PDO::PARAM_STR);
        $stmt->bindValue(':password_hash', $hash, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function updateMemberInformations($language_id, $first_name,
                                                    $last_name, $phone_number, $date_of_birth, $id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE members SET
            language_id = :language_id,
            first_name = :first_name,
            last_name = :last_name,
            phone_number = :phone_number,
            date_of_birth = :date_of_birth
            WHERE members.id = :id');
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
        $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function updateMemberEmail($email, $id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('UPDATE members SET email = :email
            WHERE id = :id');
        $stmt->bindvalue(':email', $email, PDO::PARAM_STR);
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function addMemberNewsletter($newsletter_id, $id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT * FROM members_newsletters WHERE member_id = :id AND newsletter_id = :newsletter_id'
        );
        $stmt->bindvalue(':newsletter_id', $newsletter_id, PDO::PARAM_INT);
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            $stmt = $db->prepare(
                'INSERT INTO members_newsletters (newsletter_id, member_id)
             VALUES (:newsletter_id, :id)'
            );
            $stmt->bindvalue(':newsletter_id', $newsletter_id, PDO::PARAM_INT);
            $stmt->bindvalue(':id', $_SESSION['member'][0], PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public static function deleteMemberFromNewsletter($newsletter_id, $id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'DELETE FROM members_newsletters WHERE
            newsletter_id = :newsletter_id AND member_id = :id'
        );
        $stmt->bindvalue(':newsletter_id', $newsletter_id, PDO::PARAM_INT);
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function getUpcomingTrips($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT trips.id,
            trips.departure_date,
            trips.return_date,
            circuits.name
            FROM trips
            INNER JOIN circuits_trips ON circuits_trips.id = trips.circuit_trip_id
            INNER JOIN circuits ON circuits.id = circuits_trips.circuit_id
            WHERE trips.member_id = :id AND trips.return_date >= NOW() - INTERVAL 1 DAY ORDER BY trips.departure_date'
        );
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getTrips($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT trips.id,
            trips.departure_date,
            trips.return_date,
            circuits.name
            FROM trips
            INNER JOIN circuits_trips ON circuits_trips.id = trips.circuit_trip_id
            INNER JOIN circuits ON circuits.id = circuits_trips.circuit_id
            WHERE trips.member_id = :id ORDER BY trips.departure_date'
        );
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPayments($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT trips_payments.id,
                trips_payments.amount_due,
                trips_payments.date_due,
                trips_payments.transaction_id,
                circuits_trips.departure_date,
                circuits.name
                FROM trips_payments
                INNER JOIN payments_plans ON payments_plans.id = trips_payments.payment_plan_id
                INNER JOIN circuits_trips ON payments_plans.circuit_trip_id = circuits_trips.id
                INNER JOIN circuits ON circuits_trips.circuit_id = circuits.id
                INNER JOIN trips ON trips_payments.trip_id = trips.id
                LEFT JOIN transactions ON trips_payments.transaction_id = transactions.id
                WHERE trips.member_id = :id ORDER BY trips_payments.date_due DESC'
        );
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPaymentsUpcoming($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT trips_payments.id,
                trips_payments.amount_due,
                trips_payments.date_due,
                trips_payments.transaction_id,
                circuits_trips.departure_date,
                circuits.name
                FROM trips_payments
                INNER JOIN payments_plans ON payments_plans.id = trips_payments.payment_plan_id
                INNER JOIN circuits_trips ON payments_plans.circuit_trip_id = circuits_trips.id
                INNER JOIN circuits ON circuits_trips.circuit_id = circuits.id
                INNER JOIN trips ON trips_payments.trip_id = trips.id
                LEFT JOIN transactions ON trips_payments.transaction_id = transactions.id
                WHERE trips.member_id = :id AND trips_payments.transaction_id IS NULL
                AND trips_payments.date_due >= NOW() - INTERVAL 30 DAY
                ORDER BY trips_payments.date_due ASC'
        );
        $stmt->bindvalue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getLanguages()
    {
        $db = static::getDB();
        $stmt = $db->prepare(
            'SELECT *
                FROM languages'
        );
        $stmt->execute();
        return $stmt->fetchAll();
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

        $hash = LoginHelpers::encryptPassword($password, $password_salt);

        return $hash === $password_hash;
    }
}
