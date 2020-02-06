<?php

namespace App\Controllers;

use App\Models\Member;
use \Core\Controller;
use \Core\View;

use App\Helpers\LoginHelpers;
use App\Models\Traveler;

class Travelers extends Controller
{

    public function addTravelerAction(){
        if (empty($_POST['inputFirstName'])) {
            $errors['inputFirstName'][] = 'Veuillez fournir un prénom';
        }

        if (empty($_POST['inputLastName'])) {
            $errors['inputLastName'][] = 'Veuillez fournir un nom';
        }

        if (empty($_POST['inputPhoneNumber'])) {
            $errors['inputPhoneNumber'][] = 'Veuillez fournir un numéro de téléphone';
        }

        if (empty($_POST['inputBirthDate'])) {
            $errors['inputBirthDate'][] = 'Veuillez fournir une date de naissance';
        }

        if (empty($_POST['inputGenre'])) {
            $errors['inputGenre'][] = 'Veuillez choisir un genre';
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $phone_errors = LoginHelpers::validatePhoneNumber($_POST['inputPhoneNumber']);
        if (!empty($phone_errors)) {
            $errors['phone'] = $phone_errors;
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $address_id = null;
        if(empty($_POST['addressCheckbox'])){
            if (empty($_POST['inputAddressLine1'])) {
                $errors['inputAddressLine1'][] = 'Veuillez fournir une adresse';
            }

            if (empty($_POST['inputRegion'])) {
                $errors['inputRegion'][] = 'Veuillez fournir une province';
            }

            if (empty($_POST['inputCountry'])) {
                $errors['inputCountry'][] = 'Veuillez fournir un pays';
            }

            if (empty($_POST['inputCity'])) {
                $errors['inputCity'][] = 'Veuillez fournir une ville dans votre adresse';
            }

            if (!empty($errors)) {
                http_response_code(400); // Bad request (missing parameters)
                View::renderJSON(['errors' => $errors]);
                return;
            }

            $address_line_2 = null;
            if (!empty($_POST['inputAddressLine2'])) {
                $address_line_2 = $_POST['inputAddressLine2'];
            }

            $postal_code = null;
            if (!empty($_POST['inputPostalCode'])) {
                $postal_code = $_POST['inputPostalCode'];
            }

            $address_id = Traveler::createTravelerAddress(
                $_POST['inputCountry'],
                $_POST['inputCity'],
                $_POST['inputCity'],
                $_POST['inputAddressLine1'],
                $address_line_2,
                $postal_code
            );
        }
        else{
            $address_id = $_POST['addressCheckbox'];
        }

        $assistance = null;
        if(empty($_POST['inputAssistance'])){
            $assistance = 0;
        }
        else{
            $assistance = 1;
        }

        $redress = null;
        if(!empty($_POST['inputRedress'])){
            $redress = $_POST['inputRedress'];
        }

        Traveler::createTraveler(
            // NON FONCTIONNEL. DOIT IMPLÉMENTER LE TRIP DANS LA SESSION
            $_SESSION['trip'][0],
            $address_id,
            $_POST['inputFirstName'],
            $_POST['inputLastName'],
            $_POST['inputBirthDate'],
            $_POST['inputPhoneNumber'],
            $_POST['inputGenre'],
            $assistance,
            $redress);
    }

    public function getTravelerCreatorAction(){
        View::renderTemplate(
            'Travelers/createForm.html.twig',
            [
                'member' => Member::getMemberInformations($_SESSION['member'][0])
            ]
        );
    }

    public function getTravelersAction(){
        View::renderTemplate(
            'Travelers/listTravelers.html.twig',
            [
                'travelers' => Traveler::getTravelers(1)
            ]
        );
    }

    public function deleteTravelerAction(){
        Traveler::deleteTraveler($_POST['id']);
    }

}
