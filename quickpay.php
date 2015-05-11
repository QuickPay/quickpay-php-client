<?php

require_once( 'quickpay/constants.php' );
require_once( 'quickpay/exceptions.php' );
require_once( 'quickpay/client.php' );
require_once( 'quickpay/request.php' );
require_once( 'quickpay/response.php' );

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
        $client = new Quickpay_Client( $auth_string );
        $this->request = new Quickpay_Request( $client);
    }
}
?>