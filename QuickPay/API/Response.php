<?php

namespace QuickPay\API;

use stdClass;

class Response
{
    public function __construct(public int $status_code, public string $sent_headers, public string $received_headers, public string $response_data)
    {
    }

    public function asRaw(bool $keep_authorization_value = false): int|string|array
    {
        // To avoid unintentional logging of credentials the default is to mask the value of the Authorization: header
        if ($keep_authorization_value) {
            $sent_headers = $this->sent_headers;
        } else {
            // Avoid dependency on mbstring
            $lines = explode("\n", $this->sent_headers);
            foreach ($lines as &$line) {
                if (strpos($line, 'Authorization: ') === 0) {
                    $line = 'Authorization: <hidden by default>';
                }
            }
            $sent_headers = implode("\n", $lines);
        }

        return [
            $this->status_code,
            [
                'sent'     => $sent_headers,
                'received' => $this->received_headers,
            ],
            $this->response_data,
        ];
    }

    public function asArray(): array
    {
        if ($response = json_decode($this->response_data, true)) {
            /** @var array $response */
            return $response;
        }

        return [];
    }

    public function asObject(): stdClass
    {
        if ($response = json_decode($this->response_data)) {
            /** @var stdClass $response */
            return $response;
        }

        return new stdClass();
    }

    public function httpStatus(): int
    {
        return $this->status_code;
    }

    public function isSuccess(): bool
    {
        return $this->status_code < 300;
    }

    /**
     * getHeaders
     *
     * Returns headers from response
     *
     * @return array
     */
    public function getHeaders()
    {
        $result = [];

        if ($headers = $this->received_headers) {
            // Filter out HTTP status and empty header lines
            $headers = array_filter(explode("\r\n", $headers), function ($header) {
                return empty($header) == false && strpos($header, ':');
            });

            // Build two dimensional key value pair array of headers
            foreach ($headers as $index => $header) {
                $headerArray = explode(':', $header);
                $key = trim($headerArray[0]);
                $value = trim($headerArray[1]);

                $headers[$key] = $value;
                unset($headers[$index]);
            }

            $result = $headers;
        }

        return $result;
    }

    /**
     * getHeader
     *
     * Gets header from received headers
     *
     * @param string|false $key
     */
    public function getHeader($key)
    {
        $result = false;
        $headers = $this->getHeaders();

        if (isset($headers[$key])) {
            $result = $headers[$key];
        }

        return $result;
    }
}
