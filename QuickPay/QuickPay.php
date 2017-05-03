<?php
namespace QuickPay;

use QuickPay\API\Client;
use QuickPay\API\Request;

class QuickPay
{
    /**
     * Contains the QuickPay_Request object
     *
     * @access public
     **/
    public $request;

    /**
     * __construct function.
     *
     * Instantiates the main class.
     * Creates a client which is passed to the request construct.
     *
     * @param string $auth_string    Authentication string for QuickPay. Format 'username:password' or ':apiKey'
     * @param string $base_url       Optional: Use a secondary API (eg billing)
     *
     * @access public
     */
    public function __construct($auth_string = '', $base_url = \QuickPay\API\Constants::API_URL)
    {
        $client = new Client($auth_string, $base_url);
        $this->request = new Request($client);
    }
}
