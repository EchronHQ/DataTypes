# Echron PHP Data Types library

[![Latest Stable Version](https://img.shields.io/packagist/v/echron/datatypes.svg)](https://packagist.org/packages/echron/datatypes)

## About

[Echron](https://echron.com) PHP Datatypes library offers a set of additional PHP data types

Install the latest version with

```bash
composer require echron/datatypes
```

## Utils

**Run PHPStan**

```bash
docker run -it -v .:/app -w /app --rm attlaz/php:8.1 composer run-script phpstan
```

**Run tests**

```bash
docker run -it -v .:/app -w /app --rm attlaz/php:8.1 vendor/bin/phpunit
```

**Update packages**

```bash
docker run -it -v .:/app -w /app --rm attlaz/php:8.1 composer update
```
