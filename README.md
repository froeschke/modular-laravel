# Modular Laravel

[![License](https://img.shields.io/packagist/l/froeschke/modular-laravel.svg?style=flat-square)](https://packagist.org/packages/froeschke/modular-laravel)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/froeschke/modular-laravel.svg?style=flat-square)](https://packagist.org/packages/froeschke/modular-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/froeschke/modular-laravel?style=flat-square)](https://packagist.org/packages/froeschke/modular-laravel)

This packages simplifies making your Laravel application modular.

The structure is inspired by [this Laracon Talk](https://speakerdeck.com/avosalmon/modularising-the-monolith-laracon-online-winter-2022) from Ryuta Hamasaki ([Repository](https://github.com/avosalmon/modular-monolith-laravel))

## Setup

```bash
composer require --dev froeschke/modular-laravel
```

```bash
php artisan modules:install
```
Optional: Publish the config file
```bash
php artisan vendor:publish --provider="Froeschke\ModularLaravel\ModularLaravelServiceProvider"
```

### Create a module
```bash
php artisan modules:create ModuleName
```

### Fix modules structure
Since empty folders are not in saved in git, you can run the following command, to ensure every folder exists:
```bash
php artisan modules:fix
```

## Testing
To enable tests, you need to modify your `phpunit.xml` configuration.
Add the following two test suites (if you've changed the default paths, you may need to change the test path)
```xml
<testsuites>
    <testsuite name="Unit">
        <directory suffix="Test.php">./modules/**/Tests/Unit</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory suffix="Test.php">./modules/**/Tests/Feature</directory>
    </testsuite>
</testsuites>
```