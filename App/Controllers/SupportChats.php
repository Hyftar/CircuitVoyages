<?php

namespace App\Controllers;

use \Core\Controller;
use \Core\View;
use \App\Models\Circuit;
use \App\Models\SupportChat;
use Symfony\Contracts\Translation\TranslatorInterface;

class SupportChats extends Controller
{
    public function before()
    {
        if (empty($_SESSION['member'])) {
            http_response_code(401);
            return false;
        }
    }

    public function sendMessageAction(TranslatorInterface $translator)
    {
        $errors = [];
        if (empty($_POST['content'])) {
            $errors[] = $translator->trans('Votre message ne peut être vide');
        }

        if (empty($_POST['room_id'])) {
            $errors[] = $translator->trans('Vous devez fournir une pièce');
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

        if (!SupportChat::memberCanSendIn($_SESSION['member']['id'], $_POST['room_id'])) {
            $errors[] = $translator->trans('Le membre ne peut envoyer de messages dans la pièce spécifiée');
            http_response_code(403);
            return;
        }


        SupportChat::memberSendMessage($_SESSION['member']['id'], $_POST['room_id'], $_POST['content']);
    }

    public function joinAction(TranslatorInterface $translator)
    {
        list($errors, $id) = SupportChat::create($_SESSION['member']['id']);
        if (!empty($errors)) {
            http_response_code(400);
            return;
        }

        SupportChat::serverSendMessage($id, $translator->trans('Nous vous mettons en contact avec un employé sous peu.'));

        View::renderJSON(
            [
                'id' => $id
            ]
        );
    }

    public function leaveAction(TranslatorInterface $translator)
    {
        $room_id = $this->route_params['roomid'];
        $user_name = $_SESSION['member']['first_name'] . ' ' . $_SESSION['member']['last_name'];
        if (!SupportChat::memberCanSendIn($_SESSION['member']['id'], $room_id)) {
            http_response_code(403);
            return;
        }

        SupportChat::serverSendMessage($room_id, "$user_name a marqué son problème comme étant résolu"); // Needs to be translated still
        SupportChat::setInactive($room_id);
    }

    public function checkMessagesAction()
    {
        $room_id = $this->route_params['roomid'];
        $message_count = SupportChat::getMessageCount($room_id)['count'];
        View::renderJSON(
            [
                'messages_count' => $message_count
            ]
        );
    }

    public function getMessageAtAction()
    {
        $id = $this->route_params['roomid'];
        $index = $this->route_params['index'];

        $message = SupportChat::getMessageAt($id, $index);
        if (!$message) {
            http_response_code(400);
            return;
        }

        View::renderTemplate(
            'Support_Chat/message.html.twig',
            [
                'messages' => [$message]
            ]
        );
    }

    public function getAllMessagesAction()
    {
        $id = $this->route_params['roomid'];

        $messages = SupportChat::getAllMessagesFromRoom($id);

        View::renderTemplate(
            'Support_Chat/message.html.twig',
            [
                'messages' => $messages
            ]
        );
    }

    public function getAllRoomsAction()
    {
        $rooms = SupportChat::getAllRoomsFromMember($_SESSION['member']['id']);
        View::renderTemplate(
            'Support_Chat/sidebar.html.twig',
            [
                'member' => $_SESSION['member'],
                'rooms' => $rooms
            ]
        );
    }
}
