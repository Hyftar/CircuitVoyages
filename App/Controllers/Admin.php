<?php

namespace App\Controllers;

use App\Helpers\ApplicationHelpers;
use App\Models\Accommodation;
use App\Models\Circuit;
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

    public function accommodationIndexAction()
    {
        $types = Accommodation::getAccommodationTypes();
        $accommodations = Accommodation::getAll();
        View::renderTemplate(
            'Admin/accommodation_index.html.twig',
            [
                'types' => $types,
                'accommodations' => $accommodations
            ]
        );
    }

    public function accommodationCreateAction()
    {
        if (empty($_POST['name'])) {
          $errors['name'][] = 'Veuillez fournir un nom pour l\'hébergement';
        }

        if (empty($_POST['type'])) {
            $errors['type'][] = 'Veuillez fournir un type d\'hébergement';
        }

        if (empty($_POST['address_line_1'])) {
            $errors['address_line_1'][] = 'Veuillez fournir une adresse';
        }

        if (empty($_POST['region'])) {
            $errors['region'][] = 'Veuillez fournir une province';
        }

        if (empty($_POST['phone'])) {
            $errors['phone'][] = 'Veuillez fournir un numéro de téléphone';
        }

        if (empty($_POST['country'])) {
            $errors['country'][] = 'Veuillez fournir un pays';
        }

        if (empty($_POST['city'])) {
            $errors['city'][] = 'Veuillez fournir une ville dans votre adresse';
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

    public function circuitsIndexAction()
    {
//        $circuits = Circuit::getAllCircuit();
        View::renderTemplate('Admin/gestion_circuits.html.twig'
//            [
//                'circuits' => $circuits
//            ]
        );
    }

    public function adminAction() {
        View::renderTemplate('admin_base.html.twig');
    }

    public function circuitsCreateIndexAction(){
        $categories = Circuit::getAllCategories();
        $languages = Circuit::getLanguages();
        $accommodations = Accommodation::getAll();
        View::renderTemplate('Admin/creation_circuit.html.twig',
            [
                'categories' => $categories,
                'languages' => $languages,
                'accommodations' => $accommodations
            ]);
    }

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
}
