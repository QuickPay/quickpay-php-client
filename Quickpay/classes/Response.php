<?php
namespace Quickpay\Classes;
/**
 * @class 		Quickpay_Response
 * @since		1.0.0
 * @package		Quickpay
 * @category	Class
 * @author 		Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://tech.quickpay.net/api/
 */
class Response
{
    protected $status_code;
    protected $response_data;
  	
    /**
     * __construct
     * 
     * Instantiates a new response object
     * 
     * @param int $response_code the http_status code
     * @param string $response_data the http response body
     */
    public function __construct( $response_code, $response_data )
    {
        $this->response_code = $response_code;
        $this->response_data = $response_data;
    }
    
    
    /**
     * asRaw
     * 
     * Returns the raw response body
     * 
     * @return string
     */    
    public function asRaw()
    {
        return $this->response_data;
    }
    

    /**
     * asArray
     * 
     * Returns the response body as an array
     * 
     * @return array
     */ 
    public function asArray()
    {
        if( $response = json_decode( $this->response_data, TRUE ) ) 
        {
            return $response;
        }

        return array();
    }

    
    /**
     * asObject
     * 
     * Returns the response body as an array
     * 
     * @return array
     */ 
    public function asObject()
    {
        if( $response = json_decode( $this->response_data ) )
        {
            return $response;
        }

        return new \stdClass;
    }
    
    
    /**
     * http_status
     * 
     * Returns the http_status code
     * 
     * @return int
     */ 
    public function http_status()
    {
        return $this->response_code;
    }
    
    
    /**
     * is_success
     * 
     * Checks if the http status code indicates a succesful or an error response.
     * 
     * @return boolean
     */   
    public function is_success()
    {
        if( $this->response_code > 299 ) 
        {
            return false;
        }
        
        return true;
    }
}
?>