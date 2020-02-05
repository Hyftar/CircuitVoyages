<?php

namespace App\Controllers;

use \App\Models\SupportChat;
use \App\Helpers\TranslationHelpers;
use \Core\Controller;
use \Core\View;

class SupportChats extends Controller
{
    public function before()
    {
        if (empty($_SESSION['member'])) {
            http_response_code(401);
            return false;
        }
    }

    public function sendMessageAction()
    {
        $translator = TranslationHelpers::getInstance();
        $errors = [];
        if (empty($_POST['content'])) {
            $errors[] = $translator->trans('Chat.Message.Empty');
        }

        if (empty($_POST['room_id'])) {
            $errors[] = $translator->trans('Chat.Room.Provide');
        }

        if (!empty($errors)) {
            http_response_code(400);
            View::renderJSON(
                [
                    'errors' => $errors,
                ]
            );
            return;
        }

        if (!SupportChat::memberCanSendIn($_SESSION['member']['id'], $_POST['room_id'])) {
            $errors[] = $translator->trans('Chat.Room.Message');
            http_response_code(403);
            return;
        }

        SupportChat::memberSendMessage($_SESSION['member']['id'], $_POST['room_id'], $_POST['content']);
    }

    public function joinAction()
    {
        $translator = TranslationHelpers::getInstance();

        list($errors, $id) = SupportChat::create($_SESSION['member']['id']);
        if (!empty($errors)) {
            http_response_code(400);
            return;
        }

        SupportChat::serverSendMessage($id, $translator->trans('Chat.Contact.Employee'));

        View::renderJSON(
            [
                'id' => $id,
            ]
        );
    }

    public function leaveAction()
    {
        $translator = TranslationHelpers::getInstance();

        $room_id = $this->route_params['roomid'];
        $user_name = $_SESSION['member']['first_name'] . ' ' . $_SESSION['member']['last_name'];
        if (!SupportChat::memberCanSendIn($_SESSION['member']['id'], $room_id)) {
            http_response_code(403);
            return;
        }

        SupportChat::serverSendMessage(
            $room_id,
            $translater->trans("Chat.user_name", ['user_name' => $user_name])
        );
        SupportChat::setInactive($room_id);
    }

    public function checkMessagesAction()
    {
        $room_id = $this->route_params['roomid'];
        $message_count = SupportChat::getMessageCount($room_id)['count'];
        View::renderJSON(
            [
                'messages_count' => $message_count,
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
                'messages' => [$message],
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
                'messages' => $messages,
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
                'rooms' => $rooms,
            ]
        );
    }
}
