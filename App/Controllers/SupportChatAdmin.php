<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Circuit;
use \Core\Controller;

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

    public function listAction()
    {

    }

    public function sendMessageAction()
    {

    }

    public function checkMessagesAction()
    {

    }

    public function joinAction()
    {

    }

    public function leaveAction()
    {

    }

    public function getAtAction()
    {

    }
}
