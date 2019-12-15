<?php


namespace App\Controllers;


use Core\Controller;
use Core\View;

class Admin extends Controller
{
    public function before()
    {
        if (empty($_SESSION['employee'])) {
            http_response_code(401);
            header('Location: /admin/login');
            return false;
        }
    }

    public function niceIndexAction()
    {
        View::renderTemplate('Admin/nice.html.twig');
    }
}
