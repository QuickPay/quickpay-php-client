<?php
/**
 * @class 		Quickpay_Response
 * @since		1.0.0
 * @package		Quickpay
 * @category	Class
 * @author 		Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://tech.quickpay.net/api/
 */
class Quickpay_Response
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
        return json_decode( $this->response_data, TRUE );
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
        return json_decode( $this->response_data );
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
}
?>