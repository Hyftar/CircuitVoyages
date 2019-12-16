<?php

namespace App\Controllers;

use \Core\View;

class Admin extends \Core\Controller
{

    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    public function circuitsIndexAction()
    {
        View::renderTemplate('Admin/gestion_circuits.html.twig');
    }

    public function adminAction() {
        View::renderTemplate('admin_base.html.twig');
    }

    public function circuitsCreateAction(){
        View::renderTemplate('Admin/creation_circuit.html.twig');
    }

    public function circuitsOrganizeAction(){
        View::renderTemplate('Admin/organisation_circuit.html.twig');
    }
}
