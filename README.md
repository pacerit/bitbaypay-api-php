# BitBayPay API
Implementation of BitBayPay REST API

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
    BitBayPayInterface::PARAMETER_ORDER_ID             => Str::random(16),
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
    ->payments($parameters);
```
## Available functions
TODO:
## Changelog

Go to the [Changelog](CHANGELOG.md) for a full change history of the package.

## Testing

    composer test

## Security Vulnerabilities

If you discover a security vulnerability within package, please send an e-mail to Wiktor Pacer
via [kontakt@pacerit.pl](mailto:kontakt@pacerit.pl). All security vulnerabilities will be promptly addressed.

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).