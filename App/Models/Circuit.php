<?php

namespace App\Models;

use App\Helpers\LoginHelpers;
use Core\Model;
use PDO;

class Circuit extends Model
{
    /*
    public static function getAllCircuit(){
        $db = static::getDB();
        $stmt = $db-> prepare();
        $stmt ->execute();
        return $stmt->fetchAll();
    }
     */

    public static function getAllCircuit(){
        $db = static::getDB();
        $stmt = $db-> prepare('SELECT
            circuits.id,
            circuits.media_id,
            circuits.language_id,
            circuits.category_id,
            circuits.name,
            circuits.description,
            circuits.is_public,
            categories.name,
            languages.name,
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id;');
        $stmt ->execute();
        return $stmt->fetchAll();
    }

    public static function getAllPublicCircuit(){
        $db = static::getDB();
        $stmt = $db-> prepare('SELECT
            circuits.id,
            circuits.media_id,
            circuits.language_id,
            circuits.category_id,
            circuits.name,
            circuits.description,
            circuits.is_public,
            categories.name,
            languages.name,
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id
            WHERE is_public = 1;');
        $stmt ->execute();
        return $stmt->fetchAll();
    }

    public static function getCircuit($id){
        $db = static::getDB();
        $stmt = $db-> prepare('SELECT
            circuits.id,
            circuits.media_id,
            circuits.language_id,
            circuits.category_id,
            circuits.name,
            circuits.description,
            circuits.is_public,
            categories.name,
            languages.name,
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id
            WHERE circuits.id =:id;');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getActivity($id){
        $db = static::getDB();
        $stmt = $db-> prepare('SELECT * FROM activities WHERE id=:id;');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getActivityLocations($id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            activities_locations.id,
            activities_locations.activity_id,
            activities_locations.location_id,
            locations.email,
            locations.phone_number,
            addresses.country,
            addresses.city,
            addresses.region,
            addresses.address_line_1,
            addresses.address_line_2,
            addresses.postal_code
            FROM activities_locations
            INNER JOIN locations ON locations.id = activities_locations.location_id
            INNER JOIN addresses ON adresses.id = locations.address_id
            WHERE activities.locations.activity_id = :id');
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt->fetchall();
    }

    public static function getActivitiesCity($city){
        $db = static::getDB();
        $stmt = $db->prepare("SELECT
            activities_locations.id,
            activities_locations.activity_id,
            activities_locations.location_id,
            locations.email,
            locations.phone_number,
            addresses.country,
            addresses.city,
            addresses.region,
            addresses.address_line_1,
            addresses.address_line_2,
            addresses.postal_code,
            activities.activity_type,
            activities.link,
            activities.description,
            activities.name
            FROM activities_locations
            INNER JOIN locations ON locations.id = activities_locations.location_id
            INNER JOIN addresses ON adresses.id = locations.address_id
            INNER JOIN activities ON activities_locations.activity_id = activities.id
            WHERE UPPER(addresses.city) LIKE UPPER('%:city%')");
        $stmt->bindValue(':city',$city,PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt->fetchall();
    }

    public static function getActivitiesCountry($country){
        $db = static::getDB();
        $stmt = $db->prepare("SELECT
            activities_locations.id,
            activities_locations.activity_id,
            activities_locations.location_id,
            locations.email,
            locations.phone_number,
            addresses.country,
            addresses.city,
            addresses.region,
            addresses.address_line_1,
            addresses.address_line_2,
            addresses.postal_code,
            activities.activity_type,
            activities.link,
            activities.description,
            activities.name
            FROM activities_locations
            INNER JOIN locations ON locations.id = activities_locations.location_id
            INNER JOIN addresses ON adresses.id = locations.address_id
            INNER JOIN activities ON activities_locations.activity_id = activities.id
            WHERE UPPER(addresses.country) LIKE UPPER('%:country%')");
        $stmt->bindValue(':country',$country,PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt->fetchall();
    }

    public static function getActivitiesRegion($region){
        $db = static::getDB();
        $stmt = $db->prepare("SELECT
            activities_locations.id,
            activities_locations.activity_id,
            activities_locations.location_id,
            locations.email,
            locations.phone_number,
            addresses.country,
            addresses.city,
            addresses.region,
            addresses.address_line_1,
            addresses.address_line_2,
            addresses.postal_code,
            activities.activity_type,
            activities.link,
            activities.description,
            activities.name
            FROM activities_locations
            INNER JOIN locations ON locations.id = activities_locations.location_id
            INNER JOIN addresses ON adresses.id = locations.address_id
            INNER JOIN activities ON activities_locations.activity_id = activities.id
            WHERE UPPER(addresses.region) LIKE UPPER('%:region%')");
        $stmt->bindValue(':region',$region,PDO::PARAM_INT);
        $stmt ->execute();
        return $stmt->fetchall();
    }

    public static function getCircuitByName($name)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            circuits.id,
            circuits.media_id,
            circuits.language_id,
            circuits.category_id,
            circuits.name,
            circuits.description,
            circuits.is_public,
            categories.name,
            languages.name,
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id
            WHERE circuits.name =:name;');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllCategories(){
        $db = static::getDB();
        $stmt = $db-> prepare('SELECT * FROM categories;');
        $stmt ->execute();
        return $stmt->fetchAll();
    }

    public static function getLanguages() {
        $db = static::getDB();
        $stmt = $db-> prepare('SELECT * FROM languages;');
        $stmt ->execute();
        return $stmt->fetchAll();
    }

    public static function getStepsForCircuit($circuit_id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM steps
            WHERE steps.circuit_id =:circuit_id;');
        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getActivitiesForStep($step_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM steps_activities
            WHERE steps_activities.step_id =:step_id;');
        $stmt->bindValue(':step_id', $step_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPeriodsForStep($step_id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM periods
            WHERE periods.step_id =:step_id;');
        $stmt->bindValue(':step_id', $step_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAccommodationsForLocation($location_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM accommodations
            WHERE accomodations.location_id =:location_id;');
        $stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getGuidesForLanguage($language_id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            employees_languages.employee_id
            FROM employees_languages
            WHERE employees_languages.language_id =:language_id;');
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getGuideById($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM employees
            WHERE employees.id =:$id;');
        $stmt->bindValue(':$id', $$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getCircuitTripForCircuit($circuit_id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM circuits_trips
            WHERE circuits_trips.circuit_id =:circuit_id;');
        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getGuidesForCircuitTrip($circuit_trip_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM circuits_trips_employees
            WHERE circuits_trips_employees.circuit_trip_id =:circuit_trip_id;');
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPaymentPlanForCircuitTrip($circuit_trip_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM payments_plans
            WHERE payments_plans.circuit_trip_id =:circuit_trip_id;');
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getTripPaymentsForPaymentPlan($payment_plan_id){
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM trips_payments
            WHERE trips_payments.payment_plan_id =:payment_plan_id;');
        $stmt->bindValue(':payment_plan_id', $payment_plan_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }





}
