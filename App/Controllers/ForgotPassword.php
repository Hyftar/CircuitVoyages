<?php

namespace App\Controllers;

use \App\Helpers\EmailHelpers;
use \App\Helpers\LoginHelpers;
use \App\Models\Member;
use \App\Models\PasswordReset;
use \Core\Controller;
use \Core\View;

class ForgotPassword extends Controller
{

    public function confirmResetAction()
    {
        $errors = [];
        if (empty($_POST['password'])) {
            $errors['password'][] = 'Veuillez fournir un mot de passe';
        }

        if (empty($_POST['token'])) {
            $errors['token'][] = 'Erreur, veuillez essayer de nouveau';
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $token = $_POST['token'];

        if (!PasswordReset::verifyToken($token)) {
            View::renderTemplate('500.html.twig');
            return;
        }

        $member_id = PasswordReset::getMemberFromToken($token);

        $errors = LoginHelpers::validatePassword($_POST['password']);

        if (!empty($errors)) {
            View::renderTemplate('500.html.twig');
            return;
        }

        Member::updateMemberPassword($_POST['password'], $member_id);
        PasswordReset::deleteTokens($member_id);

        header('Location: /');
    }

    public function showResetPageAction()
    {
        if (empty($this->route_params['variables']['token'])) {
            View::renderTemplate("404.html.twig");
            return;
        }


        $token = $this->route_params['variables']['token'];

        if (!PasswordReset::verifyToken($token)) {
            View::renderTemplate("404.html.twig");
            return;
        }

        View::renderTemplate('Members/password_reset.html.twig', ['token' => $token]);
    }

    public function sendEmailAction()
    {
        $errors = [];
        if (empty($_POST['email'])) {
            $errors['email'][] = 'Veuillez fournir un email';
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(['errors' => $errors]);
            return;
        }

        $email = $_POST['email'];
        $member = Member::getByEmail($email);

        if ($member == false) {
            return;
        }

        $token = PasswordReset::generateToken($email);

        if ($token == false) {
            return;
        }

        $email_content = View::outputTemplate(
            'Members/password_reset_email.html.twig',
            ['token' => $token]
        );

        $member_full_name = $member['first_name'] . ' ' . $member['last_name'];

        EmailHelpers::sendEmail(
            $email,
            $member_full_name,
            'Réinitialisation de mot de passe',
            $email_content
        );
    }
}
