<?php

namespace App\Controllers;

use \Core\View;

class Circuits extends \Core\Controller
{

    public function showAction()
    {
        View::renderTemplate('Circuits/show.html.twig');
    }
}
