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
            $errors[] = 'Email invalide';
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

        http_response_code(200);
    }

    public function logoutAction()
    {

    }

    public function createAction()
    {

    }

    public function updateAction()
    {

    }
}
