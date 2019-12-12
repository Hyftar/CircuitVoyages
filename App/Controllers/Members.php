<?php

namespace App\Controllers;

use \Core\View;
use \App\Helpers\LoginHelpers;
use \App\Models\Member;

class Members extends \Core\Controller
{
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

        session_destroy();
        session_start();

        $_SESSION['user'] = Member::getByEmail($_POST['email']);
    }

    public function logoutAction()
    {
        session_destroy();
    }

    public function createAction()
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob']; // Date of birth
        $address_line_1 = $_POST['address_line_1'];
        $address_line_2 = $_POST['address_line_2'];
        $country = $_POST['country'];
        $region = $_POST['region'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $postal_code = $_POST['postal_code'];
        $password = $_POST['password'];

        $errors = [];

        // Check if all the required parameters are set

        if (empty($first_name)) {
            $errors['first_name'] = 'Veuillez fournir un prénom';
        }

        if (empty($last_name)) {
            $errors['last_name'] = 'Veuillez fournir un nom';
        }

        if (empty($email)) {
          $errors['email'] = 'Veuillez fournir un email';
        }

        if (empty($address_line_1)) {
            $errors['address_line_1'] = 'Veuillez fournir une adresse';
        }

        if (empty($region)) {
            $errors['region'] = 'Veuillez fournir une province';
        }

        if (empty($phone)) {
            $errors['phone'] = 'Veuillez fournir un numéro de téléphone';
        }

        if (empty($country)) {
            $errors['country'] = 'Veuillez fournir un pays';
        }

        if (empty($dob)) {
            $errors['dob'] = 'Veuillez fournir une date de naissance';
        }

        if (empty($city)) {
            $errors['city'] = 'Veuillez fournir une ville dans votre adresse';
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        // Validate parameters content

        if (!LoginHelpers::isValidEmail($_POST['email'])) {
            $errors['email'] = 'Format du email invalide';
        }

        $errors['password'] =
            LoginHelpers::validatePassword($password);

        $postal_code_validation =
            LoginHelpers::validatePostalCode($postal_code);
        $postal_code = $postal_code_validation[0];
        $errors['postal_code'] =
            $postal_code_validation[1];

        if (!empty($errors['pasword']) ||
            !empty($errors['postal_code']) ||
            !empty($errors['email'])) {
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

    public function updateAction()
    {

    }
}
