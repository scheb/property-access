scheb/property-access
=====================

[![Build Status](https://travis-ci.org/scheb/property-access.svg?branch=master)](https://travis-ci.org/scheb/property-access)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/scheb/property-access/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/scheb/property-access/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/scheb/property-access/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/scheb/property-access/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/scheb/property-access/v/stable.svg)](https://packagist.org/packages/scheb/property-access)
[![License](https://poser.pugx.org/scheb/property-access/license.svg)](https://packagist.org/packages/scheb/property-access)

A library to read/write values from/to objects and arrays.

It is similar to [symfony/property-access](https://github.com/symfony/property-access), but is built in a more
lightweight way and therefore has less sophisticated syntax. 

Features
--------

- Read properties from objects/arrays
- Write properties from objects/arrays
- Built-in support for camel-case getters and setters
- Can be extended with your own access strategies

Installation
------------

```bash
composer require scheb/property-access
```

How to use
----------

```php
$valueObject = ...; // Array or object

$strategies = [
    new \Scheb\PropertyAccess\Strategy\ArrayAccessStrategy(),
    new \Scheb\PropertyAccess\Strategy\ObjectPropertyAccessStrategy(),
    new \Scheb\PropertyAccess\Strategy\ObjectGetterSetterAccessStrategy(),
];

$accessor = new \Scheb\PropertyAccess\PropertyAccess($strategies);

// Returns the value or null
$accessor->getPropertyValue($valueObject, 'propertyName');

// Returns the modified value object or throws FailedSettingPropertyException
$accessor->setPropertyValue($valueObject, 'propertyName', 'newValue');
```

How to extend
-------------

To create your own access strategies, implement `Scheb\PropertyAccess\Strategy\PropertyAccessStrategyInterface` and
pass in an instance of that class to the constructor argument `$propertyAccessStrategies` of
`Scheb\PropertyAccess\PropertyAccess`.

Contribute
----------
You're welcome to [contribute](https://github.com/scheb/property-access/graphs/contributors) to this library by
creating a pull requests or feature request in the issues section. For pull requests, please follow these guidelines:

- Symfony code style
- PHP7.1 type hints for everything (including: return types, `void`, nullable types)
- Please add/update test cases
- Test methods should be named `[method]_[scenario]_[expected result]`

To run the test suite install the dependencies with `composer install` and then execute `bin/phpunit`.

License
-------
This bundle is available under the [MIT license](LICENSE).
