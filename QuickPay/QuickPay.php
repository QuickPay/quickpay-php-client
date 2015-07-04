<?php
namespace QuickPay;

require_once( 'api/Constants.php' );
require_once( 'api/Exception.php' );
require_once( 'api/Client.php' );
require_once( 'api/Request.php' );
require_once( 'api/Response.php' );

use QuickPay\API\Client;
use QuickPay\API\Request;

class QuickPay
{
    /**
     * Contains the QuickPay_Request object
     * @access public
     **/
    public $request;


    /**
	* __construct function.
	*
	* Instantiates the main class.
	* Creates a client which is passed to the request construct.
	*
	* @access public
	*/
    public function __construct( $auth_string = '' )
    {
        $client = new Client( $auth_string );
        $this->request = new Request( $client );
    }
}