<?php

namespace App\Controllers;

use \Core\View;
use \Core\Controller;
use \App\Models\Circuit;
use \App\Models\SupportChat;
use Symfony\Contracts\Translation\TranslatorInterface;

class SupportChatAdmin extends Controller
{
    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    public function sendMessage(TranslatorInterface $translator)
    {
        $errors = [];
        // TODO: i18n
        if (empty($_POST['content'])) {
            $errors[] = $translator->trans('Votre message ne peut être vide');
        }

        if (empty($_POST['room_id'])) {
            $errors[] = $translator->trans('Vous devez fournir une pièce');
        }

        if (!SupportChat::employeeCanSendIn($_SESSION['employee']['id'], $_POST['room_id'])) {
            $errors[] = 'Vous ne pouvez envoyer de message dans cette session';
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(
                [
                    'errors' => $errors
                ]
            );
            return;
        }

        SupportChat::employeeSendMessage($_SESSION['employee']['id'], $_POST['room_id'], $_POST['content']);
    }

    public function join()
    {
        $employee_name = $_SESSION['employee']['first_name'] . ' ' . $_SESSION['employee']['last_name'];
        if (!SupportChat::employeeJoin($_SESSION['employee']['id'], $_POST['room_id'])) {
            http_response_code(400);
            return;
        }

        SupportChat::serverSendMessage($_POST['room_id'], "$employee_name s'est connecté, faites-lui part de votre problème."); // Needs to be translated still
    }

    public function leave()
    {
        $room_id = $this->route_params['roomid'];
        $employee_name = $_SESSION['employee']['first_name'] . ' ' . $_SESSION['employee']['last_name'];
        if (!SupportChat::employeeLeave($_SESSION['employee']['id'], $room_id)) {
            http_response_code(400);
            return;
        }

        SupportChat::serverSendMessage($room_id, "$employee_name s'est déconnecté."); // Need to be translated still
    }

    public function getMessageAt()
    {
        $id = $this->route_params['roomid'];
        $index = $this->route_params['index'];

        $message = SupportChat::getMessageAt($id, $index);
        if (!$message) {
            http_response_code(400);
            return;
        }

        View::renderTemplate(
            'Support_Chat/message_admin.html.twig',
            [
                'messages' => [$message]
            ]
        );
    }

    public function checkMessages()
    {
        $room_id = $this->route_params['roomid'];
        $message_count = SupportChat::getMessageCount($room_id)['count'];
        View::renderJSON(
            [
                'messages_count' => $message_count
            ]
        );
    }

    public function getAllMessages()
    {
        $id = $this->route_params['roomid'];

        $messages = SupportChat::getAllMessagesFromRoom($id);

        View::renderTemplate(
            'Support_Chat/message_admin.html.twig',
            [
                'messages' => $messages
            ]
        );
    }

    public function getAllRooms()
    {
        $rooms = SupportChat::getAllRooms();
        View::renderTemplate(
            'Support_Chat/sidebar_admin.html.twig',
            [
                'rooms' => $rooms
            ]
        );
    }
}
