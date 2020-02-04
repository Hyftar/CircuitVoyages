<?php


namespace App\Helpers;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailHelpers
{

    public static function sendEmail($recepientEmail, $recepientName, $subject, $content)
    {
        $errors = [];
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Mailer = "smtp";
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "lelabernoiscircuits@gmail.com";
        $mail->Password = "MBGLAProductions";

        $mail->IsHTML(true);
        $mail->AddAddress($recepientEmail, $recepientName);
        $mail->SetFrom("lelabernoiscircuits@gmail.com", "Le Labernois");
        $mail->Subject = $subject;
        $content = $content;

        $mail->MsgHTML($content);
        $mail->Send();
    }

    public static function sendEmailBBC($recepientsEmailList, $subject, $content)
    {
        $errors = [];
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = "smtp.gmail.com";
        $mail->Username = "lelabernoiscircuits@gmail.com";
        $mail->Password = "MBGLAProductions";

        $mail->IsHTML(true);
        foreach($recepientsEmailList as $email){
            $mail->AddBCC($email);
        }
        $mail->SetFrom("lelabernoiscircuits@gmail.com", "Le Labernois");
        $mail->Subject = $subject;
        $content = $content;

        $mail->MsgHTML($content);
        $mail->Send();
    }
}
