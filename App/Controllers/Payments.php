<?php

namespace App\Controllers;

use \Core\View;
use App\Models\TripPayment;
use App\Models\PayPalOrder;
use PHPUnit\Util\Exception;


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
        $amount = $_POST['details']['purchase_units'][0]['amount']['value'];
        if ($_SESSION['order_id'] != $_POST['details']['id']) {
            throw new Exception('Order ID is different');
        }

        $tpid = $_SESSION['tpid'];

        TripPayment::addTransaction($tpid, $payer_id, $amount, $order_id);

        header("Refresh:0");
    }

    public function getOrderIdAction()
    {
        $amount = TripPayment::getPaymentAmount($this->route_params['tpid'])['amount'];
        $result = PayPalOrder::createOrder($amount);

        $_SESSION['order_id'] = $result->result->id;
        $_SESSION['tpid'] = $this->route_params['tpid'];

        View::renderJSON($result);
    }
}
