<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        $member = null;
        if (!empty($_SESSION['member'])) {
            $member = $_SESSION['member'];
        }

        View::renderTemplate('Home/index.html.twig', ['member' => $member]);
    }
}
