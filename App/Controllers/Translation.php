<?php
namespace App\Controllers;

use Core\Controller;

class Translation extends \Core\Controller
{

    public function setLocaleAction()
    {
        if (emtpy($_POST['selectedValue']) || !in_array($_POST['selectedValue'], ['fr', 'en', 'es'])) {
            $_SESSION['locale'] = 'fr';
            return;
        }

        $_SESSION['locale'] = $_POST['selectedValue'];
    }
}
