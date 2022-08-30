<?php

namespace QuickPay\Tests;

use PHPUnit\Framework\TestCase;
use QuickPay\API\Client;
use QuickPay\API\Request;
use QuickPay\API\Response;

class RequestTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Request
     */
    protected $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->client  = new Client();
        $this->request = new Request($this->client);
    }

    /**
     * @test
     */
    public function responseInstance()
    {
        $pingResponse = $this->request->get('/ping');

        $this->assertTrue($pingResponse instanceof Response);
    }

    /**
     * @test
     */
    public function badAuthentication()
    {
        $client  = new Client(':foo');
        $request = new Request($client);

        $response = $request->get('/ping');

        $this->assertSame(401, $response->httpStatus());
    }

    /**
     * @test
     */
    public function successfulGetResponse()
    {
        $pingResponse = $this->request->get('/ping');

        $this->assertTrue($pingResponse->isSuccess());
    }

    /**
     * @test
     */
    public function failedGetResponse()
    {
        $pingResponse = $this->request->get('/foobar');

        $this->assertFalse($pingResponse->isSuccess());
    }

    /**
     * @test
     */
    public function succesfulPostResponse()
    {
        $pingResponse = $this->request->post('/ping');

        $this->assertTrue($pingResponse->isSuccess());
    }

    /**
     * @test
     */
    public function failedPostResponse()
    {
        $pingResponse = $this->request->post('/foobar');

        $this->assertFalse($pingResponse->isSuccess());
    }

    /**
     * Test function added to make sure that issue gh-54 is fixed.
     *
     * @test
     */
    public function basket()
    {
        $basket    = [];
        $basket[0] = [
            'qty'        => 1,
            'item_no'    => 2,
            'item_name'  => 'Test 1',
            'item_price' => 100,
            'vat_rate'   => 0.25,
        ];
        $basket[1] = [
            'qty'        => 1,
            'item_no'    => 2,
            'item_name'  => 'Test 2',
            'item_price' => 100,
            'vat_rate'   => 0.25,
        ];

        $form = [
            'currency' => 'DKK',
            'order_id' => 1,
            'basket'   => $basket,
        ];

        $query = $this->request->httpBuildQuery($form);

        $expected = 'currency=DKK&order_id=1&basket[][qty]=1&basket[][item_no]=2&basket[][item_name]=Test 1&basket[][item_price]=100&basket[][vat_rate]=0.25&basket[][qty]=1&basket[][item_no]=2&basket[][item_name]=Test 2&basket[][item_price]=100&basket[][vat_rate]=0.25';

        $this->assertSame(urldecode($query), $expected);
    }

    /**
     * @test
     */
    public function standardHeaders()
    {
        $this->request->get('/ping');
        $this->assertStringContainsString('accept: application/json', curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT));
    }

    /**
     * @test
     */
    public function additionalHeadersOnInit()
    {
        $extra_headers = ['specialvar: foo'];
        $client        = new Client(null, $extra_headers);
        $request       = new Request($client);

        $request->get('/ping');
        $this->assertStringContainsString($extra_headers[0], curl_getinfo($client->ch, CURLINFO_HEADER_OUT));
    }

    /**
     * @test
     */
    public function additionalHeadersAfterInit()
    {
        $extra_headers = ['newvar: foo'];
        $this->client->setHeaders($extra_headers);
        $request = new Request($this->client);

        $request->get('/ping');
        $this->assertStringContainsString($extra_headers[0], curl_getinfo($this->client->ch, CURLINFO_HEADER_OUT));
    }
}
