<?php

namespace App\Controllers;

use GuzzleHttp\Client;

class PaymentController
{
    private $payment_key;
    private $config_path;

    public function __construct()
    {
        $this->config_path = require __DIR__ . '/../../Config/config.php';
        $this->payment_key = base64_encode($this->config_path['paymongo']['payment_key']);
    }

    public function payment($amount)
    {
        $amountCentavos = (int)($amount * 100);
        $client = new Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
            'json' => [
                'data' => [
                    'attributes' => [
                        'amount' => $amountCentavos,
                        'description' => 'Payment for Order',
                    ]
                ]
            ],
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Basic ' . $this->payment_key,
                'content-type' => 'application/json',
            ],
        ]);
        $body = (string) $response->getBody();
        $data = json_decode($body, true);
        $link = $data['data']['attributes']['checkout_url'];
        return $link;
    }
}
