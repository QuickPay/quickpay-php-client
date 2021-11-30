<?php

namespace QuickPay\API;

class Exception extends \Exception
{
    public function __construct(string $message, int $code = 0, self $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
