<?php
namespace Quickpay;

require_once( 'classes/constants.php' );
require_once( 'classes/exception.php' );
require_once( 'classes/client.php' );
require_once( 'classes/request.php' );
require_once( 'classes/response.php' );

use Quickpay\API\Client as Client;
use Quickpay\API\Request as Request; 

class Quickpay 
{ 
    /**
     * Contains the Quickpay_Request object
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