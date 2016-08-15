mindplay/nbase
==============

This script provides a converter between numbers encoded with *n*-base notation.

[![PHP Version](https://img.shields.io/badge/php-5.4%2B-blue.svg)](https://packagist.org/packages/mindplay/nbase)
[![Build Status](https://travis-ci.org/mindplay-dk/nbase.svg?branch=master)](https://travis-ci.org/mindplay-dk/nbase)

#### Usage

Any notation (using ASCII characters) can be used.

For example, to convert from decimal to hexadecimal notation:

```php
$converter = new NBaseConverter();

echo $converter->convert('12345', 'dec', 'hex'); // => '3039'
```

You can define your custom notations via the public `$notations` property - the
notation names supplied to the `convert` method must be defined in `$notation`.

Common notations such as `bin`, `hex`, `dec` and `oct` are pre-defined, as well as
`base62` and `base64`, plus a URL-safe variation of `base64` called `url64` which
uses `-` and `_` instead of the standard `+` and `/` used by `base64`.

Also, a useful notation `legible` is available, which excludes visually ambiguous
characters such as `1` and `l`, `0` and `O`, which can be used to shorten numeric
IDs, e.g. for use in URLs.

Refer to the [source code](src/NBaseConverter.php) for a list of pre-defined notations.
