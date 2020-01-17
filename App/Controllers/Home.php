<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Circuit;
use \App\Models\SupportChat;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        $member = null;
        $rooms = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
            $rooms = SupportChat::getAllRoomsFromMember($member['id']);
        }

        $circuits = Circuit::getLandingPageCircuits();

        View::renderTemplate(
            'Home/index.html.twig',
            [
                'member' => $member,
                'circuits' => $circuits,
                'rooms' => $rooms
            ]
        );
    }
}
