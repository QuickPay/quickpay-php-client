<?php

namespace QuickPay\Tests;

use PHPUnit\Framework\TestCase;
use QuickPay\API\Exception;

class ExceptionTest extends TestCase
{
    private $testMessage = 'Quickpay Message';
    private $testCode    = 100;

    public function testThrownExceptionValues()
    {
        try {
            throw new Exception($this->testMessage, $this->testCode);
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), $this->testMessage);
            $this->assertEquals($e->getCode(), $this->testCode);
        }
    }
}
