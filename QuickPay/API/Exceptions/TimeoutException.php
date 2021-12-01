<?php

namespace QuickPay\API\Exceptions;

class TimeoutException extends GenericException
{
    public function __construct(string $message, int $code = 0, self $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
