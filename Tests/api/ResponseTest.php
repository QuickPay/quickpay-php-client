<?php

namespace QuickPay\Tests;

use PHPUnit\Framework\TestCase;
use QuickPay\API\Response;

class ResponseTest extends TestCase
{
    private $responseTestData = '{ "key1": "value1", "key2": "value2" }';

    /**
     * Test the success response HTTP codes.
     *
     * @param string $httpCode       The HTTP code we want to test
     * @param string $expectedResult What we expect the result to be
     *
     * @dataProvider providerTestSuccessResponseHTTPCodes
     *
     * @test
     */
    public function successResponseHTTPCodes($httpCode, $expectedResult)
    {
        $response = new Response($httpCode, '', '', '');

        $result = $response->isSuccess();

        $this->assertSame($result, $expectedResult);
    }

    public function providerTestSuccessResponseHTTPCodes()
    {
        return [
            [200, true],
            [255, true],
            [299, true],
            [300, false],
            [400, false],
        ];
    }

    /**
     * Test the return of HTTP status codes.
     *
     * @param string $httpCode     The HTTP code we want to test
     * @param string $expectedCode What we expect the result to be
     *
     * @dataProvider providerTestReturnOfHTTPStatusCodes
     *
     * @test
     */
    public function returnOfHTTPStatusCodes($httpCode, $expectedCode)
    {
        $response = new Response($httpCode, '', '', '');

        $statusCode = $response->httpStatus();

        $this->assertSame($statusCode, $expectedCode);
    }

    public function providerTestReturnOfHTTPStatusCodes()
    {
        return [
            [200, 200],
            [300, 300],
            [500, 500],
        ];
    }

    /**
     * @test
     */
    public function returnOfResponseDataAsArray()
    {
        $response = new Response(200, '', '', $this->responseTestData);

        $responseArray = $response->asArray();

        $this->assertTrue(is_array($responseArray));
    }

    /**
     * @test
     */
    public function returnOfEmptyResponseDataAsArray()
    {
        $response = new Response(200, '', '', '');

        $responseArray = $response->asArray();

        $this->assertTrue(is_array($responseArray));
    }

    /**
     * @test
     */
    public function returnOfResponseDataAsObject()
    {
        $response = new Response(200, '', '', $this->responseTestData);

        $responseObject = $response->asObject();

        $this->assertTrue(is_object($responseObject));
    }

    /**
     * @test
     */
    public function returnOfEmptyResponseDataAsObject()
    {
        $response = new Response(200, '', '', '');

        $responseObject = $response->asObject();

        $this->assertTrue(is_object($responseObject));
    }

    /**
     * @test
     */
    public function returnOfResponseDataAsRaw()
    {
        $response = new Response(200, '', '', $this->responseTestData);

        [$statusCode, $headers, $responseRaw] = $response->asRaw();

        $this->assertTrue(is_int($statusCode));
        $this->assertTrue(is_array($headers));
        $this->assertTrue(is_string($responseRaw));
    }
}
