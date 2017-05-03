# Changelog

## 2.0.0 - 2017-05-03

* Set a more sane default rounding strategy: `PHP_ROUND_HALF_UP`

## 1.0.5 - 2017-04-21

* Add `roundFormat()` function which first rounds, then formats the amount, as the regular `format()` function
truncates any additional data, resulting in a loss of accuracy

## 1.0.4 - 2016-02-01

* Fix typod class name PHPDocBlockTest

## 1.0.3 - 2016-02-01

* Switch to PSR-2 style guide
* Add setDefault method to CurrencyFactory
* Allow CurrencyConversionService to be passed in to money constructor
* Add addCurrency method to CurrencyFactory
* Change CurrencyConversionServiceFactory to a service provider with get/set methods

## 1.0.2 - 2016-01-27

* Add unit tests

## 1.0.1 - 2016-01-27

* Renamed library from money-php to php-money

## 1.0.0 - 2016-01-22

* Initial release
