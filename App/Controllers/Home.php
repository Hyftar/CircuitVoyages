<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Circuit;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
        }

        $circuits = Circuit::getLandingPageCircuits();

        View::renderTemplate('Home/index.html.twig', ['member' => $member, 'circuits' => $circuits]);
    }
}
