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
     * Base url for the selected API.
     *
     * @var string
     */
    public $base_url;

    /**
     * Contains the authentication string
     *
     * @access protected
     */
    protected $auth_string;

    /**
     * __construct function.
     *
     * Instantiate object
     *
     * @access public
     * @param string $auth_string	Format 'username:password' or ':apiKey'
     * @param string $base_url		The API to call. Use on of the constants.
     * @throws Exception
     */
    public function __construct($auth_string = '', $base_url = Constants::API_URL)
    {
        // Check if lib cURL is enabled
        if (!function_exists('curl_init')) {
            throw new Exception('Lib cURL must be enabled on the server');
        }

        // Set auth string property
        $this->auth_string = $auth_string;

        // Set base url of selected API
        $this->base_url =  $base_url;

        // Instantiate cURL object
        $this->authenticate();
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
     * authenticate function.
     *
     * Create a cURL instance with authentication headers
     *
     * @access public
     */
    protected function authenticate()
    {
        $this->ch = curl_init();

        $headers = array();
        switch ($this->base_url) {
            case Constants::API_URL_INVOICING:
                $headers[] = 'Accept: application/vnd.api+json';
                break;

            case Constants::API_URL:
                $headers[] = 'Accept-Version: v' . Constants::API_VERSION;
                $headers[] = 'Accept: application/json';
                break;

            default:
                break;
        }

        if (!empty($this->auth_string)) {
            $headers[] = 'Authorization: Basic ' . base64_encode($this->auth_string);
        }

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER => $headers
        );

        curl_setopt_array($this->ch, $options);
    }
}
