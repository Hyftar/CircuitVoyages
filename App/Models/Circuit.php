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

    /* GETTERS */

    public static function getAllCircuit()
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
            categories.name AS category_name,
            languages.name AS language_name
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id;');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAllPublicCircuit()
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
            languages.name
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id
            WHERE is_public = 1;');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getCircuit($id)
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
            categories.name AS category_name,
            languages.name AS language_name
            FROM circuits
            INNER JOIN categories ON categories.id = circuits.category_id
            INNER JOIN languages ON languages.id = circuits.language_id
            WHERE circuits.id =:id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getActivity($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM activities WHERE id=:id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getActivityLocations($id)
    {
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
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchall();
    }

    public static function getActivitiesCity($city)
    {
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
        $stmt->bindValue(':city', $city, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchall();
    }

    public static function getActivitiesCountry($country)
    {
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
        $stmt->bindValue(':country', $country, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchall();
    }

    public static function getActivitiesRegion($region)
    {
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
        $stmt->bindValue(':region', $region, PDO::PARAM_INT);
        $stmt->execute();
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

    public static function getAllCategories()
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM categories;');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getLanguages()
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM languages;');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getStepsForCircuit($circuit_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM steps
            WHERE steps.circuit_id =:circuit_id;');
        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getActivitiesForStep($step_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM steps_activities
            WHERE steps_activities.step_id =:step_id;');
        $stmt->bindValue(':step_id', $step_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPeriodsForStep($step_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM periods
            WHERE periods.step_id =:step_id;');
        $stmt->bindValue(':step_id', $step_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getAccommodationsForLocation($location_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM accommodations
            WHERE accomodations.location_id =:location_id;');
        $stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getGuidesForLanguage($language_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            employees_languages.employee_id
            FROM employees_languages
            WHERE employees_languages.language_id =:language_id;');
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getGuideById($id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM employees
            WHERE employees.id =:$id;');
        $stmt->bindValue(':$id', $$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getCircuitTripForCircuit($circuit_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM circuits_trips
            WHERE circuits_trips.circuit_id =:circuit_id;');
        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getGuidesForCircuitTrip($circuit_trip_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM circuits_trips_employees
            WHERE circuits_trips_employees.circuit_trip_id =:circuit_trip_id;');
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getPaymentPlanForCircuitTrip($circuit_trip_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM payments_plans
            WHERE payments_plans.circuit_trip_id =:circuit_trip_id;');
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getTripPaymentsForPaymentPlan($payment_plan_id)
    {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM trips_payments
            WHERE trips_payments.payment_plan_id =:payment_plan_id;');
        $stmt->bindValue(':payment_plan_id', $payment_plan_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getMediaById($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT
            *
            FROM media
            WHERE media.id =:id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }



    /* ---------------------------- CREATES --------------------------  */





    public static function createActivity(
        $activity_type,
        $link,
        $description,
        $name
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO activities(
            activity_type,
            link,
            description,
            name
        ) VALUES (
            :activity_type,
            :link,
            :description,
            :name
            )'
        );

        $stmt->bindValue(':activity_type', $activity_type, PDO::PARAM_STR);
        $stmt->bindValue(':link', $link, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $rep = $db->lastInsertId();

        $db->commit();

        return $rep;

    }

    public static function createActivityLocation(
        $activity_id,
        $location_id
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO activities_locations(
            activity_id,
            location_id
        ) VALUES (
            :activity_id,
            :location_id
            )'
        );

        $stmt->bindValue(':activity_id', $activity_id, PDO::PARAM_INT);
        $stmt->bindValue(':location_id', $location_id , PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createCategory(
        $name,
        $description
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO activities_locations(
            name,
            description
        ) VALUES (
            :name,
            :description
            )'
        );

        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description , PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createCircuitMedia(
        $circuit_id,
        $media_id
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO circuits_media(
            circuit_id,
            media_id,
        ) VALUES (
            :circuit_id,
            :media_id
            )'
        );

        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->bindValue(':media_id', $media_id , PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }


    public static function createCircuit(
        $media_id,
        $language_id,
        $category_id,
        $name,
        $description,
        $is_public
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO circuits(
            media_id,
            language_id,
            category_id,
            name,
            description,
            is_public
        ) VALUES (
            :media_id,
            :language_id,
            :category_id,
            :name,
            :description,
            :is_public
            )'
        );


        $stmt->bindValue(':media_id', $media_id, PDO::PARAM_INT);
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':is_public', $is_public);


        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createCircuits_trips(
        $circuit_id,
        $departure_date,
        $price,
        $refund_date,
        $cancellation_date,
        $cancellation_fee,
        $places,
        $quorum,
        $is_public
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO circuits_trips(
            circuit_id,
            departure_date,
            price,
            refund_date,
            cancellation_date,
            cancellation_fee,
            places,
            quorum,
            is_public
        ) VALUES (
            :circuit_id,
            :departure_date,
            :price,
            :refund_date,
            :cancellation_date,
            :cancellation_fee,
            :places,
            :quorum,
            :is_public
            )'
        );


        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->bindValue(':departure_date', $departure_date);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':refund_date', $refund_date);
        $stmt->bindValue(':cancellation_date', $cancellation_date);
        $stmt->bindValue(':cancellation_fee', $cancellation_fee);
        $stmt->bindValue(':places', $places, PDO::PARAM_INT);
        $stmt->bindValue(':quorum', $quorum, PDO::PARAM_INT);
        $stmt->bindValue(':is_public', $is_public);


        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createCircuits_trips_employees(
        $employee_id,
        $circuit_trip_id,
        $description
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO circuits_trips_employees(
            employee_id,
            circuit_trip_id,
            description
        ) VALUES (
            :employee_id,
            :circuit_trip_id,
            :description
            )'
        );

        $stmt->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id , PDO::PARAM_INT);
        $stmt->bindValue(':description', $description , PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createPayment(
        $payment_plan_id,
        $amount_due,
        $date_due
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO payments(
            payment_plan_id,
            amount_due,
            date_due
        ) VALUES (
            :payment_plan_id,
            :amount_due,
            :date_due
            )'
        );

        $stmt->bindValue(':payment_plan_id', $payment_plan_id, PDO::PARAM_INT);
        $stmt->bindValue(':amount_due', $amount_due);
        $stmt->bindValue(':date_due', $date_due);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createPaymentPlan(
        $circuit_trip_id,
        $name
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO payments_plans(
            circuit_trip_id,
            name
        ) VALUES (
            :circuit_trip_id,
            :name
            )'
        );

        $stmt->bindValue(':circuit_trip_id', $circuit_trip_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createStep(
        $circuit_id,
        $description,
        $position,
        $time_after_last_step
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO steps(
            circuit_id,
            description,
            position,
            time_after_last_step
        ) VALUES (
            :circuit_id,
            :description,
            :position,
            :time_after_last_step
            )'
        );

        $stmt->bindValue(':circuit_id', $circuit_id, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':position', $position, PDO::PARAM_INT);
        $stmt->bindValue(':time_after_last_step', $time_after_last_step);
        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }
        $db->commit();
    }

    public static function createSteps_activities(
        $activity_id,
        $step_id,
        $time_after_last_step,
        $duration
    )
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO steps_activities(
            activity_id,
            step_id,
            time_after_last_step,
            duration
        ) VALUES (
            :activity_id,
            :step_id,
            :time_after_last_step,
            :duration
            )'
        );

        $stmt->bindValue(':activity_id', $activity_id, PDO::PARAM_INT);
        $stmt->bindValue(':step_id', $step_id, PDO::PARAM_INT);
        $stmt->bindValue(':time_after_last_step', $time_after_last_step);
        $stmt->bindValue(':duration', $duration);

        if (!$stmt->execute()) {
            $db->rollBack();
            return;
        }

        $db->commit();

    }

    public static function createEmptyCircuit()
    {
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO circuits(
        ) VALUES (NULL)'
        );

        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }
        $db->commit();
        return $row;
    }

    public static function createSimpleCircuit($media_id, $language_id, $category_id, $name, $description, $is_public){
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('INSERT INTO circuits(media_id,
            language_id,
            category_id,
            name,
            description,
            is_public)
            VALUES (:media_id, :language_id, :category_id, :name, :description, false);'
        );
        $stmt->bindValue(':media_id', $media_id, PDO::PARAM_INT);
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);

        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }
        $db->commit();
        return $row;
    }

    public static function updateSimpleCircuit($media_id, $language_id, $category_id, $name, $description, $is_public, $id){
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('UPDATE circuits SET media_id = :media_id,
            language_id = :language_id,
            category_id = :category_id,
            name = :name,
            description = :description,
            is_public = :is_public
            WHERE id = :id;'
        );
        $stmt->bindValue(':media_id', $media_id, PDO::PARAM_INT);
        $stmt->bindValue(':language_id', $language_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':is_public', $is_public, PDO::PARAM_INT);
        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }
        $db->commit();
        return $row;
    }

    public static function deleteSimpleCircuit($id){
        $db = static::getDB();
        $db->beginTransaction();

        $stmt = $db->prepare('DELETE FROM circuits_trips WHERE circuit_id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $row = $stmt->execute();
        if (!$row) {
            $db->rollBack();
            return;
        }

        $stmt = $db->prepare('DELETE FROM circuits WHERE id = :id;');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $row = $stmt->execute();

        if (!$row) {
            $db->rollBack();
            return;
        }

        $db->commit();
        return $row;
    }
}
