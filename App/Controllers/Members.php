<?php

namespace App\Controllers;

use \Core\View;
use \App\Helpers\LoginHelpers;
use \App\Helpers\ApplicationHelpers;
use \App\Models\Member;
use \App\Models\SupportChat;

class Members extends \Core\Controller
{
    public function googleLoginAction()
    {
        if (empty($_POST['name'])) {
            // TODO: use i18n string instead
            $errors[] = 'Veuillez fournir un nom';
        }
        if (empty($_POST['id'])) {
            $errors[] = 'Veuillez fournir un id';
        }
        if (empty($_POST['email'])) {
            $errors[] = 'Veuillez fournir un email';
        }
        if (!empty($errors)) {
            http_response_code(401);
            View::renderJSON(['errors' => $errors]);
            return;
        }
        $names = explode(' ', $_POST['name']);
        $first_name = $names[0];
        $last_name = $names[array_key_last($names)];
        $member = Member::googleIdExists($_POST['id']);
        $email = $_POST['email'];
        if (empty($member)) {
            Member::createMemberForGoogle($_POST['id'], $first_name, $last_name, $email);
            $member = Member::googleIdExists($_POST['id']);
        }
        $_SESSION['member'] = $member;
    }

    public function facebookLoginAction()
    {
        if (empty($_POST['name'])) {
            // TODO: use i18n string instead
            $errors[] = 'Veuillez fournir un nom';
        }

        if (empty($_POST['id'])) {
            $errors[] = 'Veuillez fournir un id';
        }

        if (!empty($errors)) {
            http_response_code(401);
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $names = explode(' ', $_POST['name']);
        $first_name = $names[0];
        $last_name = $names[array_key_last($names)];
        $member = Member::facebookIdExists($_POST['id']);

        if (empty($member)) {
            Member::createMemberForFacebook($_POST['id'], $first_name, $last_name);
            $member = Member::facebookIdExists($_POST['id']);
        }

        $_SESSION['member'] = $member;
    }

    public function loginAction()
    {
        $errors = [];
        if (!array_key_exists('email', $_POST) ||
            !LoginHelpers::isValidEmail($_POST['email'])) {
            // TODO: use i18n string instead
            $errors[] = 'Format du email invalide';
        }

        if (!array_key_exists('password', $_POST)) {
            $errors[] = 'Veuillez fournir un mot de passe';
        } else {
            $errors = array_merge(
                $errors,
                LoginHelpers::validatePassword($_POST['password'])
            );
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderTemplate(
                'Members/login_errors.html.twig',
                ['errors' => $errors]
            );
            return;
        }

        if (!Member::exists($_POST['email']) ||
            !Member::isCorrectPassword($_POST['email'], $_POST['password'])) {
            // TODO: use i18n string instead
            $errors[] = 'Email ou mot de passe invalide';
            http_response_code(401);
            View::renderTemplate(
                'Members/login_errors.html.twig',
                ['errors' => $errors]
            );
            return;
        }

        $_SESSION['member'] = Member::getByEmail($_POST['email']);
    }

    public function logoutAction()
    {
        session_destroy();
    }

    public function createAction()
    {
        $errors = [];

        // Check if all the required parameters are set

        if (empty($_POST['first_name'])) {
            $errors['first_name'][] = 'Veuillez fournir un prénom';
        }

        if (empty($_POST['last_name'])) {
            $errors['last_name'][] = 'Veuillez fournir un nom';
        }

        if (empty($_POST['email'])) {
          $errors['email'][] = 'Veuillez fournir un email';
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

        if (empty($_POST['dob'])) {
            $errors['date_of_birth'][] = 'Veuillez fournir une date de naissance';
        }

        if (empty($_POST['city'])) {
            $errors['city'][] = 'Veuillez fournir une ville dans votre adresse';
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob']; // Date of birth
        $address_line_1 = $_POST['address_line_1'];
        $address_line_2 = null;
        $country = $_POST['country'];
        $region = $_POST['region'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $postal_code = null;
        $password = $_POST['password'];

        if (!empty($_POST['address_line_2'])) {
            $address_line_2 = $_POST['address_line_2'];
        }

        if (!empty($_POST['postal_code'])) {
            $postal_code = $_POST['postal_code'];
        }

        // Validate parameters content

        // Email

        if (!LoginHelpers::isValidEmail($_POST['email'])) {
            $errors['email'][] = 'Format du email invalide';
        }

        if (Member::exists($email)) {
            $errors['email'][] = 'Un compte existe deja pour ce email';
        }

        // Password

        $password_errors =
            LoginHelpers::validatePassword($password);

        if (!empty($password_errors)) {
            $errors['password'] = $password_errors;
        }

        // Postal code

        list($postal_code, $postal_code_errors) =
            LoginHelpers::validatePostalCode($postal_code);

        if (!empty($postal_code_errors)) {
            $errors['postal_code'][] = $postal_code_errors;
        }

        // Phone

        $phone_errors = LoginHelpers::validatePhoneNumber($phone);
        if (!empty($phone_errors)) {
            $errors['phone'] = $phone_errors;
        }

        // Date of birth

        // 16 years old minimum
        $dob_errors = ApplicationHelpers::validateDate($dob, 16);
        if (!empty($dob_errors)) {
            $errors['dob'] = $dob_errors;
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::createMember(
            $email,
            $password,
            $first_name,
            $last_name,
            $phone,
            $dob,
            $country,
            $city,
            $region,
            $address_line_1,
            $address_line_2,
            $postal_code
        );
    }

    public function showAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
        }

        View::renderTemplate(
            'Members/account.html.twig',
            [
                'member' => $member,
            ]
        );
    }

    public function showInformationsAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $infos = Member::getMemberInformations($member[0]);
            $languages = Member::getLanguages();
        }

        View::renderTemplate(
            'Members/informations.html.twig',
            [
                'member' => $member,
                'infos' => $infos,
                'languages' => $languages
            ]
        );
    }

    public function sendInformationsAction(){
        $errors = [];
        // Check if all the required parameters are set
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

        if (empty($_POST['inputLanguage'])) {
            $errors['inputLanguage'][] = 'Veuillez fournir une langue de préférence';
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $first_name = $_POST['inputFirstName'];
        $last_name = $_POST['inputLastName'];
        $dob = $_POST['inputBirthDate']; // Date of birth
        $phone = $_POST['inputPhoneNumber'];
        $language =$_POST['inputLanguage'];

        // Validate parameters content

        // Phone

        $phone_errors = LoginHelpers::validatePhoneNumber($phone);
        if (!empty($phone_errors)) {
            $errors['phone'] = $phone_errors;
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::updateMemberInformations(
            $language,
            $first_name,
            $last_name,
            $phone,
            $dob,
            $_SESSION['member'][0]
        );
    }

    public function showCoordinatesAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $coordinates = Member::getMemberAddress($member[0]);
        }

        View::renderTemplate(
            'Members/coordinates.html.twig',
            [
                'member' => $member,
                'address' => $coordinates
            ]
        );
    }

    public function showSecurityAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $informations = Member::getMemberInformations($member[0]);
        }

        View::renderTemplate(
            'Members/security.html.twig',
            [
                'member' => $member,
                'informations' => $informations,
            ]
        );
    }

    public function showCommunicationsAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $newsletters = Member::getMemberNewsletters($member[0]);
            $infos = Member::getMemberInformations($member[0]);
        }

        View::renderTemplate(
            'Members/communications.html.twig',
            [
                'member' => $member,
                'newsletters' => $newsletters,
                'informations' => $infos
            ]
        );
    }

    public function showTripsAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $trips = Member::getTrips($_SESSION['member'][0]);
        }

        $history = true;
        View::renderTemplate(
            'Members/trips.html.twig',
            [
                'member' => $member,
                'trips' => $trips,
                'allHistory' => $history
            ]
        );
    }

    public function showTripsUpcomingAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $trips = Member::getUpcomingTrips($_SESSION['member'][0]);
        }
        $history = false;
        View::renderTemplate(
            'Members/trips.html.twig',
            [
                'member' => $member,
                'trips' => $trips,
                'allHistory' => $history
            ]
        );
    }
    public function showPaymentsAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $payments = Member::getPayments($_SESSION['member'][0]);
        }

        View::renderTemplate(
            'Members/payments.html.twig',
            [
                'member' => $member,
                'payments' => $payments,
                'allHistory' => true
            ]
        );
    }

    public function showPaymentsUpcomingAction(){
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $payments = Member::getPaymentsUpcoming($_SESSION['member'][0]);
        }

        View::renderTemplate(
            'Members/payments.html.twig',
            [
                'member' => $member,
                'payments' => $payments,
                'allHistory' => false
            ]
        );
    }
    public function sendCommunicationsAction(){
        $errors = [];

        if (!LoginHelpers::isValidEmail($_POST['inputEmail'])) {
            $errors['email'][] = 'Format du email invalide';
        }

        if (Member::exists($_POST['inputEmail'])) {
            $errors['email'][] = 'Un compte existe déjà pour ce email';
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::updateMemberEmail($_POST['inputEmail'], $_SESSION['member'][0]);

    }

    public function suscribeAction(){
        Member::addMemberNewsletter($_POST['id'], $_SESSION['member'][0]);
    }

    public function unsuscribeAction(){
        Member::deleteMemberFromNewsletter($_POST['id'], $_SESSION['member'][0]);
    }

    public function sendSecurityAction(){
        $errors = [];

        if (!Member::comparePassword($_POST['inputOldPassword'], $_SESSION['member'][0]))
            $errors['oldPassword'][] = 'L\'ancien mot de passe n\'est pas valide.';

        $password_errors =
            LoginHelpers::validatePassword($_POST['inputNewPassword']);

        if (!empty($password_errors)) {
            $errors['password'] = $password_errors;
        }

        if ($_POST['inputNewPassword'] != $_POST['inputNewPasswordBis'])
            $errors['newPassword'][] = 'Les nouveaux mots de passe ne sont pas identiques.';

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::updateMemberPassword($_POST['inputNewPassword'], $_SESSION['member'][0]);
    }

    public function sendCoordinatesAction(){
        $errors = [];

        // Check if all the required parameters are set

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

        $address_line_1 = $_POST['inputAddressLine1'];
        $address_line_2 = null;
        $country = $_POST['inputCountry'];
        $region = $_POST['inputRegion'];
        $city = $_POST['inputCity'];
        $postal_code = null;

        if (!empty($_POST['inputAddressLine2'])) {
            $address_line_2 = $_POST['inputAddressLine2'];
        }

        if (!empty($_POST['inputPostalCode'])) {
            $postal_code = $_POST['inputPostalCode'];
        }

        // Validate parameters content

        // Postal code
        list($postal_code, $postal_code_errors) =
            LoginHelpers::validatePostalCode($postal_code);

        if (!empty($postal_code_errors)) {
            $errors['inputPostalCode'][] = $postal_code_errors;
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::updateMemberAddress(
            $_SESSION['member'][0],
            $country,
            $city,
            $region,
            $address_line_1,
            $address_line_2,
            $postal_code
        );

    }

}
