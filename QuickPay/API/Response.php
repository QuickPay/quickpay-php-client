<?php
namespace QuickPay\API;
/**
 * @class 		QuickPay_Response
 * @since		1.0.0
 * @package		QuickPay
 * @category	Class
 * @author 		Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://tech.quickpay.net/api/
 */
class Response
{
	/**
	 * HTTP status code of request.
	 *
	 * @var integer
	 */
    protected $status_code;

	/**
	 * The headers sent during the request.
	 *
	 * @var string
	 */
	protected $sent_headers;

	/**
	 * The headers received during the request.
	 *
	 * @var string
	 */
	protected $received_headers;

	/**
	 * Response body of last request.
	 *
	 * @var string
	 */
    protected $response_data;

	/**
     * __construct
     * 
     * Instantiates a new response object
     * 
     * @param int $status_code the HTTP status code
	 * @param string $sent_headers the headers sent
	 * @param string $received_headers the headers received
     * @param string $response_data the http response body
     */
    public function __construct( $status_code, $sent_headers, $received_headers, $response_data )
    {
        $this->status_code = $status_code;
        $this->sent_headers = $sent_headers;
        $this->received_headers = $received_headers;
        $this->response_data = $response_data;
    }
    
    
    /**
     * as_raw
     * 
     * Returns the HTTP status code, headers and response body.
	 * Usage: list($status_code, $headers, $response_body) = $response->as_raw().
     * 
	 * @param boolan $keep_authorization_value	Normally the value of the Authorization: header is masked. True keeps the sent value.
     * @return array			[integer, string[], string]
     */    
    public function as_raw( $keep_authorization_value = false )
    {
		// To avoid unintentional logging of credentials the default is to mask the value of the Authorization: header
		if ($keep_authorization_value )
		{
			$sent_headers = $this->sent_headers;
		}
		else
		{
			// Avoid dependency on mbstring
			$lines = explode( "\n", $this->sent_headers );
			foreach ( $lines as &$line )
			{
				if (strpos($line, 'Authorization: ') === 0) {
					$line = 'Authorization: <hidden by default>';
				}
			}
			$sent_headers = implode("\n", $lines);
		}

        return [
			$this->status_code,
			[	'sent' => $sent_headers,
				'received' => $this->received_headers,
			],
			$this->response_data,
		];
    }
    
    /**
     * as_array
     * 
     * Returns the response body as an array
     * 
     * @return array
     */ 
    public function as_array()
    {
        if( $response = json_decode( $this->response_data, TRUE ) ) 
        {
            return $response;
        }

        return array();
    }

    
    /**
     * as_object
     * 
     * Returns the response body as an array
     * 
     * @return array
     */ 
    public function as_object()
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
        return $this->status_code;
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
        if( $this->status_code > 299 )
        {
            return false;
        }
        
        return true;
    }
}
