# Conveniently route all emails to a local mailbox.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jstoone/nova-mailman.svg?style=flat-square)](https://packagist.org/packages/jstoone/nova-mailman)
![CircleCI branch](https://img.shields.io/circleci/project/github/jstoone/nova-mailman/master.svg?style=flat-square)
[![Build Status](https://img.shields.io/travis/jstoone/nova-mailman/master.svg?style=flat-square)](https://travis-ci.org/jstoone/nova-mailman)
[![Quality Score](https://img.shields.io/scrutinizer/g/jstoone/nova-mailman.svg?style=flat-square)](https://scrutinizer-ci.com/g/jstoone/nova-mailman)
[![Total Downloads](https://img.shields.io/packagist/dt/jstoone/nova-mailman.svg?style=flat-square)](https://packagist.org/packages/jstoone/nova-mailman)

When the `log`-driver doesn't cut it, and you can't be bothered looking for your [Mailtrap](https://mailtrap.io) credentials, Nova Mailman is ... your man.

![Screenshot of Larvel Mailman tool](https://jstoone.github.io/nova-mailman/screenshot.png)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require jstoone/nova-mailman
```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        new \Jstoone\Mailman\Tool(),
    ];
}
```

## Usage

Click on the "nova-mailman" menu item in your Nova app to see the tool provided by this package.

## Testing

``` bash
phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jstoone@drk.sh instead of using the issue tracker.

## Credits

- [Jakob Steinn](https://github.com/jstoone)
- [Mohamed Said](https://github.com/themsaid)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
