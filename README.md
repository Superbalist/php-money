# php-money

A money and currency library for handling arbitrary-precision arithmetic

[![Author](http://img.shields.io/badge/author-@superbalist-blue.svg?style=flat-square)](https://twitter.com/superbalist)
[![Build Status](https://img.shields.io/travis/Superbalist/php-money/master.svg?style=flat-square)](https://travis-ci.org/Superbalist/php-money)
[![StyleCI](https://styleci.io/repos/50180994/shield?branch=master)](https://styleci.io/repos/50180994)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/superbalist/php-money.svg?style=flat-square)](https://packagist.org/packages/superbalist/php-money)
[![Total Downloads](https://img.shields.io/packagist/dt/superbalist/php-money.svg?style=flat-square)](https://packagist.org/packages/superbalist/php-money)


## Installation

```bash
composer require superbalist/php-money
```

## Usage

```php
use Superbalist\Money\CurrencyConversionServiceProvider;
use Superbalist\Money\CurrencyFactory;
use Superbalist\Money\Money;
use Superbalist\Money\OpenExchangeRatesCurrencyConversionService;

// set default currency conversion service
// this is optional, and is only required if you're going to be converting between currencies
$service = new OpenExchangeRatesCurrencyConversionService('[[insert app id here]]');
CurrencyConversionServiceProvider::setCurrencyConversionService($service);

// set default currency
CurrencyFactory::setDefault('ZAR');

// a money object can be constructed very loosely
$a = new Money(150);
$a = new Money('150'); // recommended
$a = new Money('150.00');
$a = new Money(150.00); // not recommended, as we're trying to avoid using floating points
$a = new Money('150', CurrencyFactory::make('USD'));

// basic operations on numbers
$a = new Money('150.55');
$b = new Money('99.45');
$c = $a->add($b); // 250

$a = new Money('300.00');
$b = new Money('2');
$c = $a->divide($b); // 150

// comparing numbers
$a = new Money('0.33');
$b = new Money('0.33');
$c = $a->equals($b); // true
$c = $a->isGreaterThan($b); // false
$c = $a->isGreaterThanOrEqualTo($b); // true
$c = $a->isLessThan($b); // false

// convert a monetary value from currency A to currency B
$a = new Money('100', CurrencyFactory::make('ZAR'));
$b = $a->toCurrency(CurrencyFactory::make('USD'));

// format a number for display
$a = new Money('123.9999');
echo $a->format(); // 123.99
echo $a->display(); // R123.99

// handling value added tax
$a = new Money('100');
$rate = '0.14';
$b = $a->calculateVat($rate); // 14
$c = $a->add($b); // 114
$d = $c->calculateNetVatAmount($rate); // 100

// min & max
$a = new Money('100');
$b = new Money('101');
$c = $a->max($b); // 101
$d = $a->min($b); // 100

// ...see classes for full list of methods
```