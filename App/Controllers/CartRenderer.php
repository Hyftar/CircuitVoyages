<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Circuit;

class CartRenderer extends \Core\Controller
{
    public function getCartRowAction()
    {
        if (empty($_SESSION['member'])) {
            $member = null;
        } else {
            $member = $_SESSION['member'];
        }
        View::renderTemplate(
            'Cart/cart_row.html.twig',
            [
                'member' => $member,
                'id' => urldecode($this->route_params['variables']['id']),
                'name' => urldecode($this->route_params['variables']['name']),
                'departure_date' => urldecode($this->route_params['variables']['date']),
                'price' => urldecode($this->route_params['variables']['price'])
            ]
        );
    }
}
