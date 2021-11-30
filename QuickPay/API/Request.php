<?php

namespace QuickPay\API;

class Request
{
    public Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $path, array $query = []): Response
    {
        if (!empty($query)) {
            if (strpos($path, '?') === false) {
                $path .= '?' . http_build_query($query, '', '&');
            } else {
                $path .= ini_get('arg_separator.output') . http_build_query($query, '', '&');
            }
        }

        $this->setUrl($path);

        return $this->execute('GET');
    }

    public function post(string $path, array $form = []): Response
    {
        $this->setUrl($path);

        return $this->execute('POST', $form);
    }

    public function put(string $path, array $form = []): Response
    {
        $this->setUrl($path);

        return $this->execute('PUT', $form);
    }

    public function patch(string $path, array $form = []): Response
    {
        $this->setUrl($path);

        return $this->execute('PATCH', $form);
    }

    public function delete(string $path, array $form = []): Response
    {
        $this->setUrl($path);

        return $this->execute('DELETE', $form);
    }

    protected function setUrl(string $url): void
    {
        curl_setopt($this->client->ch, CURLOPT_URL, Constants::API_URL . trim($url, '/'));
    }

    protected function execute(string $request_type, array $form = []): Response
    {
        // Set the HTTP request type
        curl_setopt($this->client->ch, CURLOPT_CUSTOMREQUEST, $request_type);

        // If additional data is delivered, we will send it along with the API request
        if (is_array($form) && !empty($form)) {
            curl_setopt($this->client->ch, CURLOPT_POSTFIELDS, $this->httpBuildQuery($form));
        }

        // Set Timeout (15 seconds)
        curl_setopt($this->client->ch, CURLOPT_TIMEOUT, 15);

        /** @var resource $fh_header */
        $fh_header = fopen('php://temp', 'w+b');
        curl_setopt($this->client->ch, CURLOPT_WRITEHEADER, $fh_header);
        curl_setopt($this->client->ch, CURLINFO_HEADER_OUT, true);

        // Execute the request
        $response_data = (string) curl_exec($this->client->ch);

        if (curl_errno($this->client->ch) !== 0) {
            // An error occurred
            fclose($fh_header);
            throw new Exception(curl_error($this->client->ch), curl_errno($this->client->ch));
        }

        // @phpstan-ignore-next-line
        $sent_headers = (string) curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT);
        rewind($fh_header);
        $received_headers = (string) stream_get_contents($fh_header);
        fclose($fh_header);

        // @phpstan-ignore-next-line
        $response_code = (int) curl_getinfo($this->client->ch, CURLINFO_HTTP_CODE);

        // Return the response object.
        return new Response($response_code, $sent_headers, $received_headers, $response_data);
    }

    public function httpBuildQuery(array $query): array|string|null
    {
        $query = http_build_query($query, '', '&');

        return preg_replace('/%5B[0-9]+%5D/i', '%5B%5D', $query);
    }
}
