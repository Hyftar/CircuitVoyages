<?php

namespace App\Controllers;

use App\Models\Newsletter;
use Core\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use App\Helpers\ApplicationHelpers;
use App\Models\Accommodation;
use App\Models\Activity;
use App\Models\Circuit;
use App\Models\CircuitTrip;
use App\Models\Media;
use \Core\View;

class Newsletters extends \Core\Controller
{

    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    public function sendEmailMethod($recepientEmail, $recepientName, $subject, $content){
        $errors = [];
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "lelabernoiscircuits@gmail.com";
        $mail->Password   = "MBGLAProductions";

        $mail->IsHTML(true);
        $mail->AddAddress($recepientEmail, $recepientName);
        $mail->SetFrom("lelabernoiscircuits@gmail.com", "Le Labernois");
        $mail->Subject = $subject;
        $content = $content;

        $mail->MsgHTML($content);
        if(!$mail->Send()) {
            $errors['email'][] = 'Email non envoyé';
            http_response_code(400); // Bad request (missing parameters)
            View::renderJSON(['errors' => $errors]);
            return;
        }
    }

    public function getNewsletterCreatorAction(){
        View::renderTemplate(
            'Newsletters/createNewsletter.html.twig'
        );
    }

    public function createNewsletterAction(){
        Newsletter::createNewsletter($_POST['newsletter_name']);
    }

    public function getNewsletterUpdaterAction(){
        $newsletter = Newsletter::getNewsletter($_POST['id']);
        View::renderTemplate(
            'Newsletters/updateNewsletter.html.twig',
            [
                'newsletter' => $newsletter
            ]
        );
    }

    public function saveNewsletterUpdateAction(){
        Newsletter::updateNewsletter($_POST['newsletter_id'],$_POST['newsletter_name']);
    }

    public function getNewslettersAction(){
        $newsletters = Newsletter::getNewsletters();
        View::renderTemplate(
            'Newsletters/index.html.twig',
            [
                'newsletters' => $newsletters
            ]
        );
    }

    public function getMessagesAction(){
        $messages = Newsletter::getNewsletterMessages($_POST['id']);
        $newsletter = Newsletter::getNewsletter($_POST['id']);
        View::renderTemplate(
            'Newsletters/listMessages.html.twig',
            [
                'messages' => $messages,
                'newsletter' => $newsletter
            ]
        );
    }

    public function getMessageCreatorAction(){
        $newsletter = Newsletter::getNewsletter($_POST['id']);
        View::renderTemplate(
            'Newsletters/newMessage.html.twig',
            [
                'newsletter' => $newsletter
            ]
        );
    }

    public function deleteNewsletterAction(){
        Newsletter::deleteNewsletter($_POST['id']);
    }

    public function sendMessage(){
        Newsletter::sendNewsletterMessage($_POST['inputSubject'],$_POST['inputContent'],$_POST['newsletterId']);
        $members = Newsletter::getNewsletterMembers($_POST['newsletterId']);
        foreach($members as $member){
            $this->sendEmailMethod($member['email'],$member['first_name']." ".$member['last_name'],$_POST['inputSubject'],$_POST['inputContent']);
        }
    }
}



