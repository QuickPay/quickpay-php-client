<?php
namespace QuickPay\API;

use QuickPay\API\Constants;
use QuickPay\API\Response;

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
	* @param  string $path
	* @param  array  $query
	* @return Response
	*/    
    public function get( $path, $query = array() )
    {
		// Add query parameters to $path?
		if ( $query )
		{
			if (strpos($path, '?') === false )
			{
				$path .= '?' . http_build_query($query);
			}
			else
			{
				$path .= ini_get('arg_separator.output') . http_build_query($query);
			}
		}

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
	* @return Response
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
	* @return Response
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
	* @return Response
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
	* @return Response
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
	* @return Response
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

		// Store received headers in temporary memory file, remember sent headers
		$fh_header = fopen('php://memory', 'w+');
		curl_setopt($this->client->ch, CURLOPT_WRITEHEADER, $fh_header);
		curl_setopt($this->client->ch, CURLINFO_HEADER_OUT, true);

 		// Execute the request
 		$response_data = curl_exec( $this->client->ch );

		if (curl_errno($this->client->ch) !== 0) {
 			//An error occurred
			fclose($fh_header);
 			throw new Exception(curl_error($this->client->ch), curl_errno($this->client->ch));
 		}

		// Grab the headers
		$sent_headers = curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT);
		rewind($fh_header);
		$received_headers = stream_get_contents($fh_header);
		fclose($fh_header);

 		// Retrieve the HTTP response code
 		$response_code = (int) curl_getinfo( $this->client->ch, CURLINFO_HTTP_CODE );

 		// Return the response object.
 		return new Response( $response_code, $sent_headers, $received_headers, $response_data );
 	}

}
