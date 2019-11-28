<?php

namespace App\Controllers;

use \Core\View;

class Admin extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Admin/index.html.twig');
    }
}
