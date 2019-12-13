<?php

namespace App\Controllers;

use \Core\View;
use \App\Helpers\LoginHelpers;
use \App\Helpers\ApplicationHelpers;
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
            $errors['email'][] = ['Format du email invalide'];
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
            $errors['date_of_birth'] = $dob_errors;
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

    public function updateAction()
    {

    }
}
