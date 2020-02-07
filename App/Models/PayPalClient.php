<?php

namespace App\Models;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "AcwWV7u7X5pYJHF2X3qDf_pTN5Gbk2MrMCrFMOj8Ipz3g9MI5nCVrrVQ3IC6IFbnx8ArJVrJJ3PTpDvG";
        $clientSecret = getenv("CLIENT_SECRET") ?: "EBTdIi7o7eWszmr-MoPJq6wmZyI1vUJOtLuGuIGSXhQcxlrvCjCBGPqkx-TzGscYVC6X_4INjnG1eVwA";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}
