<?php

namespace App\Controllers;

use \Core\View;

class Admin extends \Core\Controller
{

    public function indexAction()
    {
        View::renderTemplate('Admin/gestion_circuits.html.twig');
    }

    public function createIndexAction(){
        View::renderTemplate('Admin/creation_circuit.html.twig');
    }
}
