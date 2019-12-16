<?php
namespace QuickPay\API;

use QuickPay\API\Constants;
use QuickPay\API\Response;

/**
 * @class      QuickPay_Request
 * @since      0.1.0
 * @package    QuickPay
 * @category   Class
 * @author     Patrick Tolvstein, Perfect Solution ApS
 * @docs       http://tech.quickpay.net/api/
 */
class Request
{
    /**
     * Contains QuickPay_Client instance
     *
     * @access public
     * @var Client
     */
    public $client;

    /**
     * __construct function.
     *
     * Instantiates the object
     *
     * @access public
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * GET function.
     *
     * Performs an API GET request
     *
     * @access public
     * @param  string $path
     * @param  array  $query
     * @return Response
     */
    public function get($path, $query = array())
    {
        // Add query parameters to $path?
        if (!empty($query)) {
            if (strpos($path, '?') === false) {
                $path .= '?' . http_build_query($query, '', '&');
            } else {
                $path .= ini_get('arg_separator.output') . http_build_query($query, '', '&');
            }
        }

        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('GET');
    }

    /**
     * POST function.
     *
     * Performs an API POST request
     *
     * @access public
     * @return Response
     */
    public function post($path, $form = array())
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('POST', $form);
    }

    /**
     * PUT function.
     *
     * Performs an API PUT request
     *
     * @access public
     * @return Response
     */
    public function put($path, $form = array())
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('PUT', $form);
    }

    /**
     * PATCH function.
     *
     * Performs an API PATCH request
     *
     * @access public
     * @return Response
     */
    public function patch($path, $form = array())
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('PATCH', $form);
    }

    /**
     * DELETE function.
     *
     * Performs an API DELETE request
     *
     * @access public
     * @return Response
     */
    public function delete($path, $form = array())
    {
        // Set the request params
        $this->setUrl($path);

        // Start the request and return the response
        return $this->execute('DELETE', $form);
    }

    /**
     * setUrl function.
     *
     * Takes an API request string and appends it to the API url
     *
     * @access protected
     * @return void
     */
    protected function setUrl($params)
    {
        curl_setopt($this->client->ch, CURLOPT_URL, Constants::API_URL . trim($params, '/'));
    }

    /**
     * EXECUTE function.
     *
     * Performs the prepared API request
     *
     * @access protected
     * @param  string $request_type
     * @param  array  $form
     * @return Response
     */
    protected function execute($request_type, $form = array())
    {
        // Set the HTTP request type
        curl_setopt($this->client->ch, CURLOPT_CUSTOMREQUEST, $request_type);

        // If additional data is delivered, we will send it along with the API request
        if (is_array($form) && ! empty($form)) {
            curl_setopt($this->client->ch, CURLOPT_POSTFIELDS, $this->httpBuildQuery($form));
        }

        // Store received headers in temporary memory file, remember sent headers
        $fh_header = fopen('php://temp', 'w+');
        curl_setopt($this->client->ch, CURLOPT_WRITEHEADER, $fh_header);
        curl_setopt($this->client->ch, CURLINFO_HEADER_OUT, true);

        // Execute the request
        $response_data = curl_exec($this->client->ch);

        if (curl_errno($this->client->ch) !== 0) {
            // An error occurred
            fclose($fh_header);
            throw new Exception(curl_error($this->client->ch), curl_errno($this->client->ch));
        }

        // Grab the headers
        $sent_headers = curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT);
        rewind($fh_header);
        $received_headers = stream_get_contents($fh_header);
        fclose($fh_header);

        // Retrieve the HTTP response code
        $response_code = (int) curl_getinfo($this->client->ch, CURLINFO_HTTP_CODE);

        // Return the response object.
        return new Response($response_code, $sent_headers, $received_headers, $response_data);
    }

    /**
     * Improves http_build_query() for the QuickPay use case.
     *
     * Kept public for testing purposes.
     *
     * @param array $query
     * @return mixed|string
     */
    public function httpBuildQuery($query)
    {
        $query = http_build_query($query, '', '&');
        $query = preg_replace('/%5B[0-9]+%5D/i', '%5B%5D', $query);
        return $query;
    }
}
