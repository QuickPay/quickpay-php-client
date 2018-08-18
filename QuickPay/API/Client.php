<?php
namespace QuickPay\API;

/**
 * @class       QuickPay_Client
 * @since       0.1.0
 * @package     QuickPay
 * @category    Class
 * @author      Patrick Tolvstein, Perfect Solution ApS
 * @docs        http://tech.quickpay.net/api/
 */
class Client
{
    /**
     * Contains cURL instance
     *
     * @access public
     */
    public $ch;

    /**
     * Contains the authentication string
     *
     * @access protected
     */
    protected $auth_string;

    /**
     * Contains the headers
     *
     * @access protected
     */
    protected $headers = array();

    /**
     * __construct function.
     *
     * Instantiate object
     *
     * @access public
     */
    public function __construct($auth_string = '', $additional_headers = array())
    {
        // Check if lib cURL is enabled
        if (!function_exists('curl_init')) {
            throw new Exception('Lib cURL must be enabled on the server');
        }

        // Set auth string property
        $this->auth_string = $auth_string;

        // Set headers
        $this->headers = array(
            'Accept-Version: v10',
            'Accept: application/json',
        );

        if (!empty($this->auth_string)) {
            $this->headers[] = 'Authorization: Basic ' . base64_encode($this->auth_string);
        }

        // Instantiate cURL object
        $this->authenticate();

        $this->setHeaders($additional_headers);
    }

    /**
     * Shutdown function.
     *
     * Closes the current cURL connection
     *
     * @access public
     */
    public function shutdown()
    {
        if (!empty($this->ch)) {
            curl_close($this->ch);
        }
    }

    /**
     * Set additinal headers to cURL
     *
     * @access public
     * @return boolean
     */
    public function setHeaders($additional_headers = array())
    {
        if (!empty($additional_headers)) {
            $this->headers = array_merge($this->headers, $additional_headers);
        }
        return curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
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
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC
        );

        curl_setopt_array($this->ch, $options);
    }
}
