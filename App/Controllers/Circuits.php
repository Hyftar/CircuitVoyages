<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Circuit;

class Circuits extends \Core\Controller
{

    public function showAction()
    {
        $circuit = Circuit::getInfo($this->route_params['id']);
        View::renderTemplate('Circuits/show.html.twig', [ 'circuit' => $circuit ]);
    }
}
