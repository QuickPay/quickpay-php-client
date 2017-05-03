quickpay-php-client
======================

[![Build Status](https://travis-ci.org/QuickPay/quickpay-php-client.svg)](https://travis-ci.org/QuickPay/quickpay-php-client) [![Code Coverage](https://scrutinizer-ci.com/g/QuickPay/quickpay-php-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/QuickPay/quickpay-php-client/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/QuickPay/quickpay-php-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/QuickPay/quickpay-php-client/?branch=master) [![Latest Stable Version](https://poser.pugx.org/quickpay/quickpay-php-client/v/stable)](https://packagist.org/packages/quickpay/quickpay-php-client) [![Total Downloads](https://poser.pugx.org/quickpay/quickpay-php-client/downloads)](https://packagist.org/packages/quickpay/quickpay-php-client) [![License](https://poser.pugx.org/quickpay/quickpay-php-client/license)](https://packagist.org/packages/quickpay/quickpay-php-client)

`quickpay-php-client` is a official client for [QuickPay API](http://tech.quickpay.net/api). The QuickPay API enables you to accept payments in a secure and reliable manner. This package currently support QuickPay `v10` api.

## Installation

### Composer

Simply add a dependency on quickpay/quickpay-php-client to your project's composer.json file if you use Composer to manage the dependencies of your project. Here is a minimal example of a composer.json file that just defines a dependency on newest stable version of QuickPay:

```
{
    "require": {
        "quickpay/quickpay-php-client": "1.0.*"
    }
}
```

### Manually upload

If you cannot use composer and all the goodness the autoloader in composer gives you, you can upload `/QuickPay/` to your web space. However, then you need to manage the autoloading of the classes yourself.

## Usage

Before doing anything you should register yourself with QuickPay and get access credentials. If you haven't please [click](https://quickpay.net/) here to apply.

### Create a new client

First you should create a client instance that is anonymous or authorized with `api_key` or login credentials provided by QuickPay.

To initialise an anonymous client:

```php5
<?php
use QuickPay\QuickPay;

try {
    $client = new QuickPay();
} catch (Exception $e) {
    //...
}
?>
```

To initialise a client with QuickPay Api Key:

```php5
<?php
use QuickPay\QuickPay;

try {
    $api_key = 'xxx';
    $client = new QuickPay(":{$api_key}");
} catch (Exception $e) {
    //...
}
?>
```

Or you can provide login credentials like:

```php5
<?php
use QuickPay\QuickPay;

try {
    $qp_username = 'xxx';
    $qp_password = 'xxx';
    $client = new QuickPay("{$qp_username}:{$qp_password}");
} catch (Exception $e) {
    //...
}
?>
```


### API Calls

You can afterwards call any method described in QuickPay api with corresponding http method and endpoint. These methods are supported currently: `get`, `post`, `put`, `patch` and `delete`.

```php5
// Get all payments
$payments = $client->request->get('/payments');

// Get specific payment
$payments = $client->request->get('/payments/{id}');

// Create payment
$form = array(
    'order_id' => $order_id,
    'currency' => $currency,
    ...
);
$payments = $client->request->post('/payments', $form);
$status = $payments->httpStatus();
if ($status == 201) {
    // Successful created
}

```

### Handling the response
Getting the `HTTP status code`:

```php5
$response = $client->request->get('/payments');
$status = $response->httpStatus();

if ($status == 200) {
    // Successful request
}
```

The returned response object supports 3 different ways of returning the response body, `asRaw()`, `asObject`, `asArray()`.

```php5
// Get the HTTP status code, headers and raw response body.
list($status_code, $headers, $response_body) = $client->request->get('/payments')->asRaw();

// Get the response body as an object
$response_body = $client->request->get('/payments')->asObject();

// Get the response body as an array
$response_body = $client->request->get('/payments')->asArray();

// Example usage
$payments = $client->request->get('/payments')->asArray();

foreach($payments as $payment) {
    //...
}

```

You can read more about api responses at [http://tech.quickpay.net/api/](http://tech.quickpay.net/api).

## Tests

Use composer to create an autoloader:

```command
$ composer install
$ phpunit
```
