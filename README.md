# BitBayPay API
![GitHub tag (latest by date)](https://img.shields.io/github/tag-date/pacerit/bitbaypay-api-php?label=Version)
![GitHub](https://img.shields.io/github/license/pacerit/bitbaypay-api-php?label=License)
![Packagist](https://img.shields.io/packagist/dt/pacerit/bitbaypay-api-php?label=Downloads)
![PHP from Packagist](https://img.shields.io/packagist/php-v/pacerit/bitbaypay-api-php?label=PHP)
[![StyleCI](https://github.styleci.io/repos/246307342/shield?branch=master)](https://github.styleci.io/repos/246307342)
[![Build Status](https://travis-ci.com/pacerit/bitbaypay-api-php.svg?branch=master)](https://travis-ci.com/pacerit/bitbaypay-api-php)

Implementation of BitBayPay REST API - https://docs.bitbaypay.com/v1.0.0-en/reference

## Installation
You can install this package by composer:
```shell script
composer require pacerit/bitbay-api-php
```
## Usage
Example call of "payments" API method:
```php
$client = new BitBayPay();

$parameters = [
    BitBayPayInterface::PARAMETER_DESTINATION_CURRENCY => 'PLN',
    BitBayPayInterface::PARAMETER_PRICE                => '1000',
    BitBayPayInterface::PARAMETER_ORDER_ID             => (string)Str::random(16),
    // This parameters below, are not required.
    // BitBayPayInterface::PARAMETER_SOURCE_CURRENCY      => '',
    // BitBayPayInterface::PARAMETER_COVERED_BY           => '',
    // BitBayPayInterface::PARAMETER_KEEP_SOURCE_CURRENCY => '',
    // BitBayPayInterface::PARAMETER_SUCCESS_CALLBACK_URL => '',
    // BitBayPayInterface::PARAMETER_FAILURE_CALLBACK_URL => '',
    // BitBayPayInterface::PARAMETER_NOTIFICATIONS_URL    => '',
];

$client->setPublicKey("YOUR_PUBLIC_KEY")
    ->setPrivateKey("YOUR_PRIVATE_KEY")
    ->createPayment($parameters);
```
## Available functions
* Start payment - https://api.bitbaypay.com/rest/bitbaypay/payments
* Get currency pairs - https://api.bitbaypay.com/rest/bitbaypay/stores/markets
* Get currency settings - https://api.bitbaypay.com/rest/bitbaypay/stores/currenciesSettings
* Payments list - https://api.bitbaypay.com/rest/bitbaypay/payments/search
* Payment details - https://api.bitbaypay.com/rest/bitbaypay/payments/{paymentId}​
## Changelog

Go to the [Changelog](CHANGELOG.md) for a full change history of the package.

## Testing
You must provide your own credentials for testing environment:
```dotenv
BITBAYPAY_TEST_PUBLIC_KEY=
BITBAYPAY_TEST_PRIVATE_KEY=
```
Run tests:

    composer test

## Security Vulnerabilities

If you discover a security vulnerability within package, please send an e-mail to Wiktor Pacer
via [kontakt@pacerit.pl](mailto:kontakt@pacerit.pl). All security vulnerabilities will be promptly addressed.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).