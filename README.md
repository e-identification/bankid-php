# BankID API library

[![PHP7.1 Ready](https://img.shields.io/badge/PHP71-ready-green.svg)][link-packagist]
[![Latest Stable Version](https://poser.pugx.org/nicklasw/bankid-sdk/v/stable)](https://packagist.org/packages/nicklasw/bankid-sdk)
[![Latest Unstable Version](https://poser.pugx.org/nicklasw/bankid-sdk/v/unstable)](https://packagist.org/packages/nicklasw/bankid-sdk)
[![Build Status](https://travis-ci.org/NicklasWallgren/bankid-sdk.svg?branch=master)](https://travis-ci.org/NicklasWallgren/bankid-sdk)
[![License](https://poser.pugx.org/nicklasw/bankid-sdk/license)](https://packagist.org/packages/nicklasw/bankid-sdk)

BankID API library

# Installation
You can install this by using composer 
```
composer require nicklasw/bankid-sdk
```

# Features
- Supports asynchronous and parallel requests

## Initiate authenticate request
```php
AnnotationRegistry::registerLoader('class_exists');

$configuration = new Config(<CERTFICATE>);
$client = new Client($configuration);

$result = $client->authenticate(
    new AuthenticationPayload(<PERSONAL NUMBER>, <IP ADDRESS>)); 
```

## Execute parallel requests
```php
AnnotationRegistry::registerLoader('class_exists');

// Example certificate for test environment.
$configuration = new Config(<CERTIFICATE>);
$client = new ClientAsynchronous($configuration);

$promises[] = $client->authenticate(new AuthenticationPayload(<PERSONAL NUMBER>, <IP ADDRESS>));
$promises[] = $client->authenticate(new AuthenticationPayload(<PERSONAL NUMBER>, <IP ADDRESS>));

// Parallel requests, authenticate users
foreach (unwrap($promises) as $result) {
    /**
     * @var AuthenticationResponse $result
     */
    var_dump($result->isSuccess());
}
```

## Generate PEM certificate
```bash
openssl pkcs12 -in <filename>.pfx -out <cert>.pem -nodes
```

## Docker 
```bash
make && make bash
```

## Unit tests
```bash
composer run test
```

## Contributing
  - Fork it!
  - Create your feature branch: `git checkout -b my-new-feature`
  - Commit your changes: `git commit -am 'Useful information about your new features'`
  - Push to the branch: `git push origin my-new-feature`
  - Submit a pull request

## Contributors
  - [Nicklas Wallgren](https://github.com/NicklasWallgren)
  - [All Contributors][link-contributors]

[ico-downloads]: https://img.shields.io/packagist/dt/nicklasw/bankid-sdk.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/nicklasw/bankid-sdk
[link-contributors]: ../../contributors