<?php

namespace QuickPay\Tests;

use QuickPay\API\Client;
use QuickPay\API\Request;
use QuickPay\API\Response;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    private $responseTestData = '{ "key1": "value1", "key2": "value2" }';

    protected $request;

    public function setUp()
    {
        $client = new Client();
        $this->request = new Request($client);
    }

    public function testResponseInstance()
    {
        $pingResponse = $this->request->get('/ping');

        $this->assertTrue( ($pingResponse instanceof Response) );
    }

    public function testBadAuthentication()
    {
        $client = new Client(':foo');
        $request = new Request($client);

        $response = $request->get('/ping');

        $this->assertEquals(401, $response->http_status());
    }

    public function testSuccessfulGetResponse()
    {
        $pingResponse = $this->request->get('/ping');

        $this->assertTrue($pingResponse->is_success());
    }

    public function testFailedGetResponse()
    {
        $pingResponse = $this->request->get('/foobar');

        $this->assertFalse($pingResponse->is_success());
    }

    public function testSuccesfulPostResponse()
    {
        $pingResponse = $this->request->post('/ping');

        $this->assertTrue($pingResponse->is_success());
    }

    public function testFailedPostResponse()
    {
        $pingResponse = $this->request->post('/foobar');

        $this->assertFalse($pingResponse->is_success());
    }

}