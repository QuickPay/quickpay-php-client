<?php

namespace QuickPay;

use QuickPay\API\Client;
use QuickPay\API\Request;

class QuickPay
{
    public static int $timeout = 15;
    /** @var callable|null */
    public static $onTimeout = null;

    public Request $request;

    public function __construct(string $auth_string = '', array $additional_headers = [], $api_url = Constants::API_URL)
    {
        $client        = new Client($auth_string, $additional_headers, $api_url);
        $this->request = new Request($client);
    }

    public function setHeaders(array $additional_headers = []): void
    {
        $this->request->client->setHeaders($additional_headers);
    }
}
