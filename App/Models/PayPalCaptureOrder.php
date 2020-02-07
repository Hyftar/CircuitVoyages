<?php

namespace App\Models;

use PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalCaptureOrder
{
    public static function captureOrder($orderId, $debug=false)
    {
        $request = new OrdersCaptureRequest($orderId);

        $client = PayPalClient::client();
        $response = $client->execute($request);
        return $response;
    }
}
