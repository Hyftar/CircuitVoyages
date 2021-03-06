<?php

namespace App\Controllers;

use \Core\View;
use \Core\Controller;
use \App\Models\Circuit;
use \App\Models\SupportChat;
use App\Helpers\TranslationHelpers;


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

    public function sendMessage()
    {
        $translator = TranslationHelpers::getInstance();

        $errors = [];
        // TODO: i18n
        if (empty($_POST['content'])) {
            $errors[] = $translator->trans('Chat.Message.Empty');
        }

        if (empty($_POST['room_id'])) {
            $errors[] = $translator->trans('Chat.Room.Provide');
        }

        if (!SupportChat::employeeCanSendIn($_SESSION['employee']['id'], $_POST['room_id'])) {
            $errors[] = $translator->trans('Chat.Message.Cannot');
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
        $translator = TranslationHelpers::getInstance();

        $employee_name = $_SESSION['employee']['first_name'] . ' ' . $_SESSION['employee']['last_name'];
        if (!SupportChat::employeeJoin($_SESSION['employee']['id'], $_POST['room_id'])) {
            http_response_code(400);
            return;
        }

        SupportChat::serverSendMessage(
            $_POST['room_id'],
            $translator->trans(
                "Chat.employee_name.Connected",
                ['employee_name' => $employee_name]
            )
        );
    }

    public function leave()
    {
        $translator = TranslationHelpers::getInstance();

        $room_id = $this->route_params['roomid'];
        $employee_name = $_SESSION['employee']['first_name'] . ' ' . $_SESSION['employee']['last_name'];
        if (!SupportChat::employeeLeave($_SESSION['employee']['id'], $room_id)) {
            http_response_code(400);
            return;
        }

        SupportChat::serverSendMessage(
            $room_id,
            $translator->trans(
                "Chat.employee_name.Disconnected",
                ['employee_name' => $employee_name]
            )
        );
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
