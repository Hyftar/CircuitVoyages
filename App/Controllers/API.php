<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Circuit;

class API extends \Core\Controller
{
    public function getCircuitsAction(){
        $circuits = Circuit::getAllInfo();
        View::renderJSON($circuits);
    }
}

