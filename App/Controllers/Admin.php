<?php

namespace App\Controllers;

use App\Helpers\ApplicationHelpers;
use App\Models\Accommodation;
use App\Models\Activity;
use App\Models\Circuit;
use App\Models\CircuitTrip;
use App\Models\Media;
use \Core\View;




class Admin extends \Core\Controller
{

    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    /* ACCOMMODATIONS */

    public function accommodationIndexAction()
    {
        $types = Accommodation::getAccommodationTypes();
        $accommodations = Accommodation::getAll();
        View::renderTemplate(
            'Accommodations/accommodation_index.html.twig',
            [
                'types' => $types,
                'accommodations' => $accommodations
            ]
        );
    }

    public function accommodationCreateAction()
    {





        if (empty($_POST['name'])) {
          $errors['name'][] = $translator->trans('Accommodation.Please.Add.Name');
        }

        if (empty($_POST['type'])) {
            $errors['type'][] = $translator->trans('Accommodation.Please.Add.Type');
        }

        if (empty($_POST['address_line_1'])) {
            $errors['address_line_1'][] = $translator->trans('Accommodation.Please.Add.Address');
        }

        if (empty($_POST['region'])) {
            $errors['region'][] = $translator->trans('Accommodation.Please.Add.Province');
        }

        if (empty($_POST['phone'])) {
            $errors['phone'][] = $translator->trans('Accommodation.Please.Add.Phone');
        }

        if (empty($_POST['country'])) {
            $errors['country'][] = $translator->trans('Accommodation.Please.Add.Country');
        }

        if (empty($_POST['city'])) {
            $errors['city'][] = $translator->trans('Accommodation.Please.Add.City');
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $link = null;
        $postal_code = null;
        $address_line_2 = null;
        $rating = null;
        $email = null;

        $address_line_1 = $_POST['address_line_1'];
        $rating = $_POST['rating'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $region = $_POST['region'];
        $county = $_POST['country'];
        $name = $_POST['name'];
        $type = $_POST['type'];

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        }

        if (!empty($_POST['link'])) {
            $link = $_POST['link'];
        }

        if (!empty($_POST['rating'])) {
            $rating = $_POST['rating'];
        }

        if (!empty($_POST['postal_code'])) {
            $postal_code = $_POST['postal_code'];
        }

        if (!empty($_POST['address_line_2'])) {
            $address_line_2 = $_POST['address_line_2'];
        }

        Accommodation::create(
            $name,
            $type,
            $email,
            $phone,
            $rating,
            $region,
            $city,
            $county,
            $address_line_1,
            $address_line_2,
            $postal_code,
            $link
        );
    }


	/* ACTIVITIES */

    public function addAccStepAction(){
        $step_id = $_POST['step_id'];
        $period_start = ((int)$_POST['period_start'] - 1) * 24 * 60;
        $accommodations = $_POST['accommodations'];
        $createPeriod = Circuit::createPeriod($step_id, $period_start);
        foreach ($accommodations as $accommodation) {
            $createAccPeriod = Circuit::createAccommodations_periods($createPeriod, $accommodation);
        }
    }

    public function deletePeriodAction(){
        $accommodations = Circuit::getAccommodationsForPeriod($_POST['period_id']);
        $deleteAccPeriods = Circuit::deleteAccommodationsForPeriod($_POST['period_id']);
        $delete = Circuit::deletePeriod($_POST['period_id']);
    }

    /* ACTIVITIES */

    public function activityIndexAction()
    {
        $types = Activity::getActivityTypes();
        $activities = Activity::getAll();
        View::renderTemplate(
            'Admin/activity_index.html.twig',
            [
                'types' => $types,
                'activities' => $activities
            ]
        );
    }

    public function activityCreateAction()
    {





        if (empty($_POST['name'])) {
            $errors['name'][] = $translator->trans('Activity.Please.Add.Name');
        }

        if (empty($_POST['type'])) {
            $errors['type'][] = $translator->trans('Activity.Please.Add.Type');
        }

        if (empty($_POST['address_line_1'])) {
            $errors['address_line_1'][] = $translator->trans('Activity.Please.Add.Address');
        }

        if (empty($_POST['region'])) {
            $errors['region'][] = $translator->trans('Activity.Please.Add.Province');
        }

        if (empty($_POST['phone'])) {
            $errors['phone'][] = $translator->trans('Activity.Please.Add.Phone');
        }

        if (empty($_POST['country'])) {
            $errors['country'][] = $translator->trans('Activity.Please.Add.Country');
        }

        if (empty($_POST['city'])) {
            $errors['city'][] = $translator->trans('Activity.Please.Add.City');
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $link = null;
        $postal_code = null;
        $address_line_2 = null;
        $description = null;
        $email = null;

        $address_line_1 = $_POST['address_line_1'];
        $description = $_POST['description'];
        $city = $_POST['city'];
        $phone = $_POST['phone'];
        $region = $_POST['region'];
        $county = $_POST['country'];
        $name = $_POST['name'];
        $type = $_POST['type'];

        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        }

        if (!empty($_POST['link'])) {
            $link = $_POST['link'];
        }

        if (!empty($_POST['description'])) {
            $description = $_POST['description'];
        }

        if (!empty($_POST['postal_code'])) {
            $postal_code = $_POST['postal_code'];
        }

        if (!empty($_POST['address_line_2'])) {
            $address_line_2 = $_POST['address_line_2'];
        }

        Activity::create(
            $name,
            $type,
            $email,
            $phone,
            $description,
            $region,
            $city,
            $county,
            $address_line_1,
            $address_line_2,
            $postal_code,
            $link
        );
    }

    /* ACTIVITIES */

    public function circuitsActivityCreateAction() {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $desc = $_POST['desc'];
        $link = $_POST['link'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $activity_id = Circuit::createActivity($type, $link, $desc, $name);

        View::renderJSON([
            'id' => $activity_id
        ]);
    }

    public function listActivitiesAction() {
        $id = $_POST['step_id'];
        $activities = Circuit::getActivitiesForStep($id);
        $activities_all = Circuit::getAllActivities();
        $step = Circuit::getStep($id);
        $circuit = Circuit::getCircuit($step[1]);
        $periods = Circuit::getPeriodsForStep($id);
        $accommodations = [];
        foreach ($periods as $period){
            array_push($accommodations, Circuit::getAccommodationsForPeriod($period[0]));
        }
        $accommodations_all = Accommodation::getAll();

        View::renderTemplate('Admin/days_activities.html.twig',
            [
                'activities' => $activities,
                'activities_all' => $activities_all,
                'step' => $step,
                'circuit' => $circuit,
                'accommodations_all' => $accommodations_all,
                'periods' => $periods,
                'accommodations' => $accommodations,
            ]);
    }

    public function addActivityAction(){
        $activity_start = (int)substr($_POST['start'], 0, 1) * 60 + (int)substr($_POST['start'], 1);
        $activity_end = (int)substr($_POST['duration'], 0, 1) * 60 + (int)substr($_POST['duration'], 1);
        $activity_duration = $activity_end - $activity_start;

        $time_after_last_step = $activity_start + ((int)$_POST['day']-1)*24*60;

        $ajout = Circuit::createSteps_activities($_POST['activity_id'], $_POST['step_id'], $time_after_last_step , $activity_duration);
    }

    public function deleteActivityStepAction(){
        $delete = Circuit::deleteActivityStep($_POST['step_id'], $_POST['activity_id']);
    }

    /* ADMIN */

    public function adminAction() {
        View::renderTemplate(
            'admin_base.html.twig',
            [
                'employee' => $_SESSION['employee']
            ]
        );
    }

    public function indexAction() {
        View::renderTemplate(
            'Admin/admin_index.html.twig'
        );
    }

    /* CIRCUITS */

    public function circuitsIndexAction()
    {
        $circuits = Circuit::getAllCircuit();
        View::renderTemplate('Admin/gestion_circuits.html.twig',
            [
                'circuits' => $circuits
            ]
        );
    }

    // Ajouts de Keven

    public function circuitsCreateSimpleAction(){
        $ajout = Circuit::createSimpleCircuit($_POST['image'],
            $_POST['language'], $_POST['category'], $_POST['nomCircuit'], $_POST['descriptionCircuit'],0);
    }

    public function circuitsUpdateSimpleAction(){
        if (isset($_POST['public'])){
            $public = 1;
        }
        else{
            $public = 0;
        }
        $update = Circuit::updateSimpleCircuit($_POST['image'],
            $_POST['language'], $_POST['category'], $_POST['nomCircuit'], $_POST['descriptionCircuit'],$public, $_POST['id']);
    }

    public function circuitsCreateIndexAction(){
        $categories = Circuit::getAllCategories();
        $languages = Circuit::getLanguages();
        $images = Media::getAll();
        View::renderTemplate('Admin/create_circuit_first.html.twig',
            [
                'categories' => $categories,
                'languages' => $languages,
                'images' => $images
            ]);
    }

    public function circuitUpdateIndexAction(){
        $circuit = Circuit::getCircuit($_POST['id']);
        $categories = Circuit::getAllCategories();
        $languages = Circuit::getLanguages();
        $images = Media::getAll();
        View::renderTemplate('Admin/update_circuit_first.html.twig',
            [
                'categories' => $categories,
                'languages' => $languages,
                'images' => $images,
                'circuit' => $circuit
            ]);
    }

    public function deleteCircuitAction(){
        $delete = Circuit::deleteSimpleCircuit($_POST['id']);
    }

    public function getCircuitTripsAction(){
        $circuit = Circuit::getCircuit($_POST['id']);
        $circuitsTrips = CircuitTrip::getAllFromCircuit($_POST['id']);
        View::renderTemplate('Admin/circuit_trip_index.html.twig',
            [
                'circuit' => $circuit, 'circuits_trips' =>$circuitsTrips
            ]
        );
    }

    public function getCircuitTripCreateModalAction(){
        $circuit = Circuit::getCircuit($_POST['id']);
        View::renderTemplate('Admin/circuit_trip_create.html.twig',
            [
                'circuit' => $circuit
            ]);
    }

    public function getCircuitTripUpdateModalAction(){
        $circuit = Circuit::getCircuit($_POST['circuit_id']);
        $circuit_trip = CircuitTrip::getCircuitTrip($_POST['id']);
        View::renderTemplate('Admin/circuit_trip_update.html.twig',
            [
                'circuit' => $circuit, 'circuit_trip' => $circuit_trip
            ]);
    }

    public function getCircuitTripCreateAction(){
        if (isset($_POST['public'])){
            $public = 1;
        }
        else{
            $public = 0;
        }
        $ajout = CircuitTrip::createCircuitTrip($_POST['circuit_id'],
            $_POST['departure_date'],
            $_POST['price'],
            $_POST['refund_date'],
            $_POST['cancellation_date'],
            $_POST['cancellation_fee'],
            $_POST['places'],
            $_POST['quorum'],
            $public);
    }

    public function getCircuitTripUpdateAction(){
        if (isset($_POST['public'])){
            $public = 1;
        }
        else{
            $public = 0;
        }
        $modif = CircuitTrip::updateCircuitTrip($_POST['id'],
            $_POST['departure_date'],
            $_POST['price'],
            $_POST['refund_date'],
            $_POST['cancellation_date'],
            $_POST['cancellation_fee'],
            $_POST['places'],
            $_POST['quorum'],
            $public);
    }

    public function deleteCircuitTripAction(){
        $delete = CircuitTrip::deleteCircuitTrip($_POST['id']);
    }

    /* ETAPES */

    public function etapesIndexAction()
    {
        $circuit_id = $_POST['circuit_id'];
        $steps = Circuit::getStepsForCircuit($circuit_id);
        View::renderTemplate('Admin/gestion_etapes.html.twig',
            [
                'steps' => $steps,
                'circuit_id' => $circuit_id
            ]);
    }
    public function etapesCreateIndexAction()
    {
        View::renderTemplate('Admin/creation_etape_simple.html.twig',
            [
                'circuit_id' => $_POST['circuit_id']
            ]);
    }

    public function etapesCreateAction()
    {
        $ajout = Circuit::createStep($_POST['circuit_id'], $_POST['descriptionEtape'],
            $_POST['positionEtape'], 0);
        $periodCreate = Circuit::createPeriod($ajout, 0);
    }

    public function etapeUpdateIndexAction()
    {
        $step = Circuit::getStep($_POST['id']);
        View::renderTemplate('Admin/update_etape.html.twig',
            [
                'etape' => $step
            ]);
    }
    public function etapeUpdateAction(){
        $update = Circuit::updateStep($_POST['step_id'], $_POST['descriptionEtape'],
            $_POST['positionEtape'], 0);
    }
    public function etapeDeleteAction(){
        $periodDelete = Circuit::deletePeriod($_POST['id']);
        $delete = Circuit::deleteEtape($_POST['id']);
    }

    /* PAYMENT PLANS */

    public function paymentPlansAction(){
        $payment_plans = CircuitTrip::getPaymentPlansAll($_POST['circuit_trip_id']);
        $circuit_trip = CircuitTrip::getCircuitTrip($_POST['circuit_trip_id']);
        $circuit = Circuit::getCircuit($circuit_trip[1]);

        View::renderTemplate('Admin/payment_plans.html.twig',
            [
                'payment_plans' => $payment_plans,
                'circuit_trip' => $circuit_trip,
                'circuit' => $circuit,
            ]);
    }

    public function paymentPlanAjoutAction(){
        $ajout = CircuitTrip::createPaymentPlan($_POST['circuit_trip_id'], $_POST['name']);
    }

    public function paymentPlanSuppressionAction(){
        $payments = CircuitTrip::getPayments($_POST['payment_plan_id']);
        foreach ($payments as $payment){
            $delete = CircuitTrip::deletePayment($payment[0]);
        }
        CircuitTrip::deletePaymentPlan($_POST['payment_plan_id']);

    }


    /* PAYMENTS */

    public function paymentsAction() {
        $payment_plan = CircuitTrip::getPaymentPlan($_POST['payment_plan_id']);
        $payments = CircuitTrip::getPayments($payment_plan[0]);
        $circuit_trip = CircuitTrip::getCircuitTrip($_POST['circuit_trip_id']);
        $circuit = Circuit::getCircuit($circuit_trip[1]);

        View::renderTemplate('Admin/payments.html.twig',
            [
                'payment_plan' => $payment_plan,
                'payments' => $payments,
                'circuit_trip' => $circuit_trip,
                'circuit' => $circuit,
            ]);
    }

    public function paymentAjoutAction(){
        $date_due = date('Y-m-d', strtotime($_POST['date_due']));
        $ajout = CircuitTrip::createPayment(
            $_POST['payment_plan_id'],
            $_POST['amount_due'],
            $date_due
        );
    }

    public function paymentSuppressionAction(){
        $delete = CircuitTrip::deletePayment($_POST['payment_id']);
    }

    /* DEPRECATED */

    public function circuitsAddStepLinkAction(){
        $nbEtapes = $_POST['nbEtapes'];
        $nbEtapes += 1;
        View::renderTemplate('Admin/step_link.html.twig',
            [
                'nbEtapes' => $nbEtapes
            ]);
    }

    public function circuitsAddStepTabAction(){
        $nbEtapes = $_POST['nbEtapes'];
        $nbEtapes += 1;
        View::renderTemplate('Admin/step_tab.html.twig',
            [
                'nbEtapes' => $nbEtapes
            ]);
    }

    public function circuitsOrganizeAction(){
        View::renderTemplate('Admin/organisation_circuit.html.twig');
    }
}
