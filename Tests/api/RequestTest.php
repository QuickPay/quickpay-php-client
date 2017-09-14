<?php

namespace QuickPay\Tests;

use QuickPay\API\Client;
use QuickPay\API\Request;
use QuickPay\API\Response;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    protected $request;

    public function setUp()
    {
        $client = new Client();
        $this->request = new Request($client);
    }

    public function testResponseInstance()
    {
        $pingResponse = $this->request->get('/ping');

        $this->assertTrue(($pingResponse instanceof Response));
    }

    public function testBadAuthentication()
    {
        $client = new Client(':foo');
        $request = new Request($client);

        $response = $request->get('/ping');

        $this->assertEquals(401, $response->httpStatus());
    }

    public function testSuccessfulGetResponse()
    {
        $pingResponse = $this->request->get('/ping');

        $this->assertTrue($pingResponse->isSuccess());
    }

    public function testFailedGetResponse()
    {
        $pingResponse = $this->request->get('/foobar');

        $this->assertFalse($pingResponse->isSuccess());
    }

    public function testSuccesfulPostResponse()
    {
        $pingResponse = $this->request->post('/ping');

        $this->assertTrue($pingResponse->isSuccess());
    }

    public function testFailedPostResponse()
    {
        $pingResponse = $this->request->post('/foobar');

        $this->assertFalse($pingResponse->isSuccess());
    }

    /**
     * Test function added to make sure that issue gh-54 is fixed.
     */
    public function testBasket()
    {
        $basket = [];
        $basket[0] = [
            'qty' => 1,
            'item_no' => 2,
            'item_name' => 'Test 1',
            'item_price' => 100,
            'vat_rate' => 0.25,
        ];
        $basket[1] = [
            'qty' => 1,
            'item_no' => 2,
            'item_name' => 'Test 2',
            'item_price' => 100,
            'vat_rate' => 0.25,
        ];

        $form = [
            'currency' => 'DKK',
            'order_id' => 1,
            'basket' => $basket,
        ];

        $query = $this->request->httpBuildQuery($form);

        $expected = 'currency=DKK&order_id=1&basket[][qty]=1&basket[][item_no]=2&basket[][item_name]=Test 1&basket[][item_price]=100&basket[][vat_rate]=0.25&basket[][qty]=1&basket[][item_no]=2&basket[][item_name]=Test 2&basket[][item_price]=100&basket[][vat_rate]=0.25';

        $this->assertEquals(urldecode($query), $expected);
    }
}
