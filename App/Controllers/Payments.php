<?php

namespace App\Controllers;

use \Core\View;
use App\Models\TripPayment;
use App\Models\PayPalOrder;


class Payments extends \Core\Controller
{
    public function onApproveAction()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        if (empty($_POST['data'])) {
            return;
        }

        $order_id = $_POST['data']['orderID'];
        $payer_id = $_POST['data']['payerID'];
        $_SESSION['order_id'];
        // Payment should be inserted into database
    }

    public function getOrderIdAction()
    {
        // this needs to be changed for actual amount
        $result = PayPalOrder::createOrder('500.00');

        $_SESSION['order_id'] = $result->result['id'];
        // Payment ID should be saved in the session
        View::renderJSON($result);
    }
}
