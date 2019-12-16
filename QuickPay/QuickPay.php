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
     * @var Request
     */
    public $request;

    /**
     * __construct function.
     *
     * Instantiates the main class.
     * Creates a client which is passed to the request construct.
     *
     * @auth_string string Authentication string for QuickPay
     *
     * @access public
     */
    public function __construct($auth_string = '', $additional_headers = array())
    {
        $client = new Client($auth_string, $additional_headers);
        $this->request = new Request($client);
    }

    /**
     * Add additional headers to request.
     *
     * This could be used when need to test a callback url in dev mode
     *
     *      QuickPay-Callback-Url: http://text.url/callback
     *
     * @access public
     */
    public function setHeaders($additional_headers = array())
    {
        $this->request->client->setHeaders($additional_headers);
    }
}
