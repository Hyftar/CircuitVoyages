<?php

namespace App\Controllers;

use \Core\View;

class Admin extends \Core\Controller
{

    public function circuitsIndexAction()
    {
        View::renderTemplate('Admin/gestion_circuits.html.twig');
    }

    public function adminAction() {
        View::renderTemplate('admin_base.html.twig');
    }

    public function createAction(){
        View::renderTemplate('Admin/creation_circuit.html.twig');
    }
}
