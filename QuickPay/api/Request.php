<?php
namespace QuickPay\API;

use Quickpay\API\Constants;
use Quickpay\API\Response;

/**
 * @class 		QuickPay_Request
 * @since		1.0.0
 * @package		QuickPay
 * @category	Class
 * @author 		Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://tech.quickpay.net/api/
 */
class Request
{
    /**
     * Contains QuickPay_Client instance
     * @access protected
     */   
    protected $client;
   
    
    /**
	* __construct function.
	* 
	* Instantiates the object
	*
	* @access public
	* @return object
	*/     
    public function __construct( $client )
    {
        $this->client = $client;
    }
    
    
    /**
	* get function.
	*
	* Performs an API GET request
	*
	* @access public
	* @return object
	*/    
    public function get( $path ) 
    {
        // Set the request params
        $this->set_url( $path );

        // Start the request and return the response
        return $this->execute('GET');
    }
 

   	/**
	* post function.
	*
	* Performs an API POST request
	*
	* @access public
	* @return object
	*/    
    public function post( $path, $form = array() ) 
    {
        // Set the request params
        $this->set_url( $path );

        // Start the request and return the response
        return $this->execute('POST', $form);
    }	
    

   	/**
	* put function.
	*
	* Performs an API PUT request
	*
	* @access public
	* @return object
	*/    
    public function put( $path, $form = array() ) 
    {
        // Set the request params
        $this->set_url( $path );

        // Start the request and return the response
        return $this->execute('PUT', $form);
    }	
    
    
   	/**
	* patch function.
	*
	* Performs an API PATCH request
	*
	* @access public
	* @return object
	*/    
    public function patch( $path, $form = array() ) 
    {
        // Set the request params
        $this->set_url( $path );

        // Start the request and return the response
        return $this->execute('PATCH', $form);
    }	
    
    
   	/**
	* delete function.
	*
	* Performs an API DELETE request
	*
	* @access public
	* @return object
	*/    
    public function delete( $path, $form = array() ) 
    {
        // Set the request params
        $this->set_url( $path );

        // Start the request and return the response
        return $this->execute('DELETE', $form);
    }
    
    
  	/**
	* set_url function.
	*
	* Takes an API request string and appends it to the API url
	*
	* @access protected
	* @return void
	*/   
    protected function set_url( $params ) 
    {
        curl_setopt( $this->client->ch, CURLOPT_URL, Constants::API_URL . trim( $params, '/' ) );
    }
    
    
   	/**
	* execute function.
	*
	* Performs the prepared API request
	*
	* @access protected
	* @param  string $request_type
	* @param  array  $form
	* @return object
	*/   	
 	protected function execute( $request_type, $form = array() ) 
 	{
 		// Set the HTTP request type
 		curl_setopt( $this->client->ch, CURLOPT_CUSTOMREQUEST, $request_type );

 		// If additional data is delivered, we will send it along with the API request
 		if( is_array( $form ) && ! empty( $form ) )
 		{
 			curl_setopt( $this->client->ch, CURLOPT_POSTFIELDS, http_build_query($form) );
 		}

 		// Execute the request
 		$response_data = curl_exec( $this->client->ch );

 		// Retrieve the HTTP response code
 		$response_code = (int) curl_getinfo( $this->client->ch, CURLINFO_HTTP_CODE );
        
 		// Return the response object.
 		return new Response( $response_code, $response_data );
 	}
}
