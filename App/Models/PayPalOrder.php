<?php

namespace App\Models;

use App\Models\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PayPalOrder
{
    public static function createOrder($amount, $debug=false)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody($amount);

        $client = PayPalClient::client();
        $response = $client->execute($request);

        return $response;
    }

    private static function buildRequestBody($amount)
    {
        return array(
            'intent' => 'CAPTURE',
            'purchase_units' =>
                array(
                    0 =>
                        array(
                            'amount' =>
                                array(
                                    'currency_code' => 'CAD',
                                    'value' => $amount
                                )
                        )
                )
        );
    }
}
