quickpay-php-client
======================


`quickpay-php-client` is a official client for [QuickPay API](http://tech.quickpay.net/api). The QuickPay API enables you to accept payments in a secure and reliable manner. This package currently support QuickPay `v10` api.

## Installation
Upload `/QuickPay/` to your web space.

## Usage

Before doing anything you should register yourself with QuickPay and get access credentials. If you haven't please [click](https://quickpay.net/) here to apply.

### Create a new client

First you should create a client instance that is anonymous or authorized with `api_key` or login credentials provided by QuickPay. 

To initialise an anonymous client:

```php5
<?php
    namespace QuickPay;
    require_once( 'QuickPay.php' );
    try {
        $client = new QuickPay();
    }
    catch(Exception $e) {
        //...
    }
?>
```

To initialise a client with QuickPay Api Key:

```php5
<?php
    namespace QuickPay;
    require_once( 'QuickPay.php' );
    try {
        $api_key = 'xxx';
        $client = new QuickPay(":{$api_key}");
    }
    catch(Exception $e) {
        //...
    }
?>
```

Or you can provide login credentials like:

```php5
<?php
    namespace QuickPay;
    require_once( 'QuickPay.php' );
    try {
        $qp_username = 'xxx';
        $qp_password = 'xxx';
        $client = new QuickPay("{$qp_username}:{$qp_password}");
    }
    catch(Exception $e) {
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
```

### Handling the response
Getting the `HTTP status code`:

```php5
$response = $client->request->get('/payments');
$status = $response->http_status();

if( $status == 200 ) {
    // Successful request
}
```

The returned response object supports 3 different ways of returning the response body, `as_raw()`, `as_object`, `as_array()`.

```php5
// Get the HTTP status code, headers and raw response body.
list($status_code, $headers, $response_body) = $client->request->get('/payments')->as_raw();

// Get the response body as an object
$response_body = $client->request->get('/payments')->as_object();

// Get the response body as an array
$response_body = $client->request->get('/payments')->as_array();


// Example usage
$payments = $client->request->get('/payments')->as_array();

foreach( $payments as $payment ) {
    //...
}

```

You can read more about api responses at [http://tech.quickpay.net/api/](http://tech.quickpay.net/api).

## Tests

Use composer to create an autoloader:
```command
$ composer update
$ phpunit --bootstrap vendor/autoload.php
```
