<?php

namespace QuickPay\Tests;

use QuickPay\API\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    private $responseTestData = '{ "key1": "value1", "key2": "value2" }';

    /**
     * @param string $httpCode The HTTP code we want to test
     * @param string $expectedResult What we expect the result to be
     *
     * @dataProvider providerTestSuccessResponseHTTPCodes
     */
	public function testSuccessResponseHTTPCodes($httpCode, $expectedResult)
    {
        $response = new Response($httpCode, '', '', '');
        
        $result = $response->is_success();
        
        $this->assertEquals($result, $expectedResult);
    }

    public function providerTestSuccessResponseHTTPCodes()
    {
    	return array(
    		array(200, true),
    		array(255, true),
            array(299, true),
            array(300, false),
    		array(400, false)
    	);
    }

    /**
     * @param string $httpCode The HTTP code we want to test
     * @param string $expectedCode What we expect the result to be
     *
     * @dataProvider providerTestReturnOfHTTPStatusCodes
     */
    public function testReturnOfHTTPStatusCodes($httpCode, $expectedCode)
    {
        $response = new Response($httpCode, '', '', '');
        
        $statusCode = $response->http_status();
        
        $this->assertEquals($statusCode, $expectedCode);
    }

    public function providerTestReturnOfHTTPStatusCodes()
    {
        return array(
            array(200, 200),
            array(300, 300),
            array(500, 500)
        );
    }

    public function testReturnOfResponseDataAsArray()
    {
        $response = new Response(200, '', '', $this->responseTestData);

        $responseArray = $response->as_array();

        $this->assertTrue( is_array($responseArray) );
    }

    public function testReturnOfEmptyResponseDataAsArray()
    {
        $response = new Response(200, '', '', '');

        $responseArray = $response->as_array();

        $this->assertTrue( is_array($responseArray) );
    }

    public function testReturnOfResponseDataAsObject()
    {
        $response = new Response(200, '', '', $this->responseTestData);

        $responseObject = $response->as_object();

        $this->assertTrue( is_object($responseObject) );
    }

    public function testReturnOfEmptyResponseDataAsObject()
    {
        $response = new Response(200, '', '', '');

        $responseObject = $response->as_object();

        $this->assertTrue( is_object($responseObject) );
    }

    public function testReturnOfResponseDataAsRaw()
    {
        $response = new Response(200, '', '', $this->responseTestData);

		list($statusCode, $headers, $responseRaw) = $response->as_raw();

        $this->assertTrue( is_int($statusCode) );
        $this->assertTrue( is_array($headers) );
        $this->assertTrue( is_string($responseRaw) );
    }

}