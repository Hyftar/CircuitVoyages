<?php

namespace App\Controllers;

use \App\Helpers\TranslationHelpers;
use \App\Helpers\ApplicationHelpers;
use \App\Helpers\LoginHelpers;
use \App\Models\Member;
use \Core\View;

class Members extends \Core\Controller
{
    public function googleLoginAction()
    {
        $translator = TranslationHelpers::getInstance();

        if (empty($_POST['name'])) {
            // TODO: use i18n string instead
            $errors[] = $translator->trans('Members.Google.Name');
        }
        if (empty($_POST['id'])) {
            $errors[] = $translator->trans('Members.Google.Id');
        }
        if (empty($_POST['email'])) {
            $errors[] = $translator->trans('Members.Google.Email');
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
        $translator = TranslationHelpers::getInstance();

        if (empty($_POST['name'])) {
            // TODO: use i18n string instead
            $errors[] = $translator->trans('Members.Facebook.Name');
        }

        if (empty($_POST['id'])) {
            $errors[] = $translator->trans('Members.Facebook.Id');
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
        $translator = TranslationHelpers::getInstance();
        $errors = [];
        if (!array_key_exists('email', $_POST) ||
            !LoginHelpers::isValidEmail($_POST['email'])) {
            // TODO: use i18n string instead
            $errors[] = $translator->trans('Helpers.Email.Invalid');
        }

        if (!array_key_exists('password', $_POST)) {
            $errors[] = $translator->trans('Members.Password');
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
            $errors[] = $translator->trans('Members.Invalid');
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
        $translator = TranslationHelpers::getInstance();

        $errors = [];

        // Check if all the required parameters are set

        if (empty($_POST['first_name'])) {
            $errors['first_name'][] = $translator->trans('Membres.Create.Please.Add.First');
        }

        if (empty($_POST['last_name'])) {
            $errors['last_name'][] = $translator->trans('Membres.Create.Please.Add.Name');
        }

        if (empty($_POST['email'])) {
            $errors['email'][] = $translator->trans('Membres.Create.Please.Add.Email');
        }

        if (empty($_POST['address_line_1'])) {
            $errors['address_line_1'][] = $translator->trans('Membres.Create.Please.Add.Address');
        }

        if (empty($_POST['region'])) {
            $errors['region'][] = $translator->trans('Membres.Create.Please.Add.Province');
        }

        if (empty($_POST['phone'])) {
            $errors['phone'][] = $translator->trans('Membres.Create.Please.Add.Phone');
        }

        if (empty($_POST['country'])) {
            $errors['country'][] = $translator->trans('Membres.Create.Please.Add.Country');
        }

        if (empty($_POST['dob'])) {
            $errors['date_of_birth'][] = $translator->trans('Membres.Create.Please.Add.Birth');
        }

        if (empty($_POST['city'])) {
            $errors['city'][] = $translator->trans('Membres.Create.Please.Add.City');
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
            $errors['email'][] = $translator->trans('Helpers.Email.Invalid');
        }

        if (Member::exists($email)) {
            $errors['email'][] = $translator->trans('Members.Exist');
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

    public function showAction()
    {
        $translator = TranslationHelpers::getInstance();
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

    public function showInformationsAction()
    {
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
                'languages' => $languages,
            ]
        );
    }

    public function sendInformationsAction()
    {
        $translator = TranslationHelpers::getInstance();

        $errors = [];
        // Check if all the required parameters are set
        if (empty($_POST['inputFirstName'])) {
            $errors['inputFirstName'][] = $translator->trans('Membres.Create.Please.Add.First');
        }

        if (empty($_POST['inputLastName'])) {
            $errors['inputLastName'][] = $translator->trans('Membres.Create.Please.Add.Name');
        }

        if (empty($_POST['inputPhoneNumber'])) {
            $errors['inputPhoneNumber'][] = $translator->trans('Membres.Create.Please.Add.Phone');
        }

        if (empty($_POST['inputBirthDate'])) {
            $errors['inputBirthDate'][] = $translator->trans('Membres.Create.Please.Add.Birth');
        }

        if (empty($_POST['inputLanguage'])) {
            $errors['inputLanguage'][] = $translator->trans('Members.Create.Please.Add.Language');
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
        $language = $_POST['inputLanguage'];

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

    public function showCoordinatesAction()
    {
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $coordinates = Member::getMemberAddress($member[0]);
        }

        View::renderTemplate(
            'Members/coordinates.html.twig',
            [
                'member' => $member,
                'address' => $coordinates,
            ]
        );
    }

    public function showSecurityAction()
    {
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

    public function showCommunicationsAction()
    {
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
                'informations' => $infos,
            ]
        );
    }

    public function showTripsAction()
    {
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
                'allHistory' => $history,
            ]
        );
    }

    public function showTripsUpcomingAction()
    {
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
                'allHistory' => $history,
            ]
        );
    }
    public function showPaidPaymentsAction()
    {
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $payments = Member::getPaidPayments($_SESSION['member'][0]);
        }

        View::renderTemplate(
            'Members/payments.html.twig',
            [
                'member' => $member,
                'payments' => $payments,
                'allHistory' => true,
            ]
        );
    }

    public function showUnpaidPaymentsAction()
    {
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $payments = Member::getUnpaidPayments($_SESSION['member'][0]);
        }

        View::renderTemplate(
            'Members/payments.html.twig',
            [
                'member' => $member,
                'payments' => $payments,
                'allHistory' => false,
            ]
        );
    }
    public function sendCommunicationsAction()
    {
        $translator = TranslationHelpers::getInstance();

        $errors = [];

        if (!LoginHelpers::isValidEmail($_POST['inputEmail'])) {
            $errors['email'][] = $translator->trans('Members.Format.Email');
        }

        if (Member::exists($_POST['inputEmail'])) {
            $errors['email'][] = $translator->trans('Members.Exist');
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::updateMemberEmail($_POST['inputEmail'], $_SESSION['member'][0]);
    }

    public function suscribeAction()
    {
        Member::addMemberNewsletter($_POST['id'], $_SESSION['member'][0]);
    }

    public function unsuscribeAction()
    {
        Member::deleteMemberFromNewsletter($_POST['id'], $_SESSION['member'][0]);
    }

    public function sendSecurityAction()
    {
        $translator = TranslationHelpers::getInstance();

        $errors = [];

        if (!Member::comparePassword($_POST['inputOldPassword'], $_SESSION['member'][0])) {
            $errors['oldPassword'][] = $translator->trans('Members.Password.OldI');
        }

        $password_errors =
        LoginHelpers::validatePassword($_POST['inputNewPassword']);

        if (!empty($password_errors)) {
            $errors['password'] = $password_errors;
        }

        if ($_POST['inputNewPassword'] != $_POST['inputNewPasswordBis']) {
            $errors['newPassword'][] = $translator->trans('Members.Password.Unique');
        }

        if (!empty($errors)) {
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }

        Member::updateMemberPassword($_POST['inputNewPassword'], $_SESSION['member'][0]);
    }

    public function sendCoordinatesAction()
    {
        $translator = TranslationHelpers::getInstance();

        $errors = [];

        // Check if all the required parameters are set

        if (empty($_POST['inputAddressLine1'])) {
            $errors['inputAddressLine1'][] = $translator->trans('Members.Please.Add.Adress');
        }

        if (empty($_POST['inputRegion'])) {
            $errors['inputRegion'][] = $translator->trans('Members.Please.Add.Province');
        }

        if (empty($_POST['inputCountry'])) {
            $errors['inputCountry'][] = $translator->trans('Members.Please.Add.Country');
        }

        if (empty($_POST['inputCity'])) {
            $errors['inputCity'][] = $translator->trans('Members.Please.Add.City');
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
