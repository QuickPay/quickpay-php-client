<?php
/**
 * @class 		Quickpay_Client
 * @since		1.0.0
 * @package		Quickpay
 * @category	Class
 * @author 		Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://tech.quickpay.net/api/
 */
class Quickpay_Client 
{
    /**
     * Contains cURL instance
     * @access public
     */    
    public $ch;
 
    /**
     * Contains the authentication string
     * @access protected
     */  
    protected $auth_string;
    
    
 	/**
	* __construct function.
	*
	* Instantiate object
	*
	* @access public
	*/
    public function __construct( $auth_string )
    {
        // Check if lib cURL is enabled
        if( ! function_exists('curl_init') ) 
        {
            throw new Quickpay_Exception( 'Lib cURL must be enabled on the server' );
        }
        
        // Set auth string property
        $this->auth_string = $auth_string;
        
        // Instantiate cURL object
        $this->authenticate();
    }
    
	/**
	* shutdown function.
	*
	* Closes the current cURL connection
	*
	* @access public
	*/    
    public function shutdown()
    {
        if( ! empty( $this->ch ) )
        {
            curl_close( $this->ch );
        }
    }
    
      
 	/**
	* authenticate function.
	*
	* Create a cURL instance with authentication headers
	*
	* @access public
	*/
    protected function authenticate()
    {
        $this->ch = curl_init();
        
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . base64_encode( $this->auth_string ),
                'Accept-Version: v10',
                'Accept: application/json', 
            )
        ); 
        
        curl_setopt_array( $this->ch, $options );
    }
}
?>