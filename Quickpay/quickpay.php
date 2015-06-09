<?php
namespace QuickPay;

require_once( 'api/constants.php' );
require_once( 'api/exception.php' );
require_once( 'api/client.php' );
require_once( 'api/request.php' );
require_once( 'api/response.php' );

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