<?php
namespace App\Controllers;

use App\Helpers\ApplicationHelpers;
use App\Helpers\LoginHelpers;
use App\Models\Employee;
use Core\Controller;
use Core\View;

class Employees extends Controller
{
    public function showLoginAction()
    {
        View::renderTemplate('Admin/login.html.twig');
    }

    public function createAction()
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $dob = $_POST['dob']; // Date of birth
        $phone = $_POST['phone'];
        $languages = $_POST['languages'];
        $password = null;

        $errors = [];

        // Check if all the required parameters are set

        if (empty($first_name)) {
            $errors['first_name'][] = 'Veuillez fournir un prénom';
        }

        if (empty($last_name)) {
            $errors['last_name'][] = 'Veuillez fournir un nom';
        }

        if (empty($email)) {
            $errors['email'][] = 'Veuillez fournir un email';
        }

        if (empty($phone)) {
            $errors['phone'][] = 'Veuillez fournir un numéro de téléphone';
        }

        if (empty($dob)) {
            $errors['date_of_birth'][] = 'Veuillez fournir une date de naissance';
        }

        if (empty($languages)) {
            $errors['languages'][] = 'Veuillez fournir les langues parlées par l\'employé';
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        // Validate parameters content

        // Email

        if (!LoginHelpers::isValidEmail($_POST['email'])) {
            $errors['email'][] = ['Format du email invalide'];
        }

        if (Employee::exists($email)) {
            $errors['email'][] = 'Un compte existe deja pour ce email';
        }

        // Password
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            $password_errors =
                LoginHelpers::validatePassword($password);

            if (!empty($password_errors)) {
                $errors['password'] = $password_errors;
            }
        }

        // Languages

        //$languages = unserialize($languages);

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

        if (empty($password)) {
            Employee::createEmployeeWithPassword(
                $email,
                $password,
                $first_name,
                $last_name,
                $phone,
                $dob,
                [1]
            );
            return;
        }

        Employee::createEmployee(
            $email,
            $first_name,
            $last_name,
            $phone,
            $dob,
            [1]
        );

    }

    public function logoutAction()
    {
        session_destroy();
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

        if (!Employee::exists($_POST['email']) ||
            !Employee::isCorrectPassword($_POST['email'], $_POST['password'])) {
            // TODO: use i18n string instead
            $errors[] = 'Email ou mot de passe invalide';
            http_response_code(401);
            View::renderTemplate(
                'Members/login_errors.html.twig',
                ['errors' => $errors]
            );
            return;
        }

        header('Location: /admin');
        $_SESSION['employee'] = Employee::getByEmail($_POST['email']);
    }
}
