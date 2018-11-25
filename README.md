# Conveniently route all emails to a local mailbox

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jstoone/nova-mailman.svg?style=flat-square)](https://packagist.org/packages/jstoone/nova-mailman)
[![Build Status](https://img.shields.io/travis/jstoone/nova-mailman/master.svg?style=flat-square)](https://travis-ci.org/jstoone/nova-mailman)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/6f226c77c6734ba3ace718b87281536c)](https://www.codacy.com/app/jstoone/nova-mailman?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=jstoone/nova-mailman&amp;utm_campaign=Badge_Grade)
[![Total Downloads](https://img.shields.io/packagist/dt/jstoone/nova-mailman.svg?style=flat-square)](https://packagist.org/packages/jstoone/nova-mailman)

When the `log`-driver doesn't cut it, and you can't be bothered looking for your [Mailtrap](https://mailtrap.io) credentials, Nova Mailman is ... your man.

![Screenshot of Nova Mailman](https://jstoone.github.io/nova-mailman/screenshot.png)

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

```bash
phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jstoone@drk.sh instead of using the issue tracker.

## Credits

- [Jakob Steinn](https://github.com/jstoone) - Maintainer
- [Mohamed Said](https://github.com/themsaid) - Maintainer of [Laravel Mail Preview](https://github.com/themsaid/laravel-mail-preview)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
