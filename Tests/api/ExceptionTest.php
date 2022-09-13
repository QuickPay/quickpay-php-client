<?php

namespace QuickPay\Tests;

use PHPUnit\Framework\TestCase;
use QuickPay\API\Exceptions\GenericException;

class ExceptionTest extends TestCase
{
    private $testMessage = 'Quickpay Message';
    private $testCode    = 100;

    public function testThrownExceptionValues()
    {
        try {
            throw new GenericException($this->testMessage, $this->testCode);
        } catch (GenericException $e) {
            $this->assertEquals($e->getMessage(), $this->testMessage);
            $this->assertEquals($e->getCode(), $this->testCode);
        }
    }
}
