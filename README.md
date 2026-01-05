[![codecov](https://codecov.io/gh/dhaeckel/php-basic-decimal-arithmetic/graph/badge.svg?token=3KR4PQ9E0Y)](https://codecov.io/gh/dhaeckel/php-basic-decimal-arithmetic)
[![ci](https://github.com/dhaeckel/php-basic-decimal-arithmetic/actions/workflows/php.yml/badge.svg)](https://github.com/dhaeckel/php-basic-decimal-arithmetic/actions/workflows/php.yml)
[![Static Badge](https://img.shields.io/badge/PHPStan-level%20max-brightgreen)
](phpstan.dist.neon)
![Static Badge](https://img.shields.io/badge/PHPStan-strict_rules-brightgreen)
![Packagist License](https://img.shields.io/packagist/l/haeckel/exception)


# Haeckel/php-basic-decimal-arithmetic

Simple php library for working with decimal numbers in arbitrary precision.

## Features

- Calculator interface the four basic arithmetic operations and modulo
- a type decimal num to encapsulate strings in decimal notation (main motivation was the bcmath required format)
- a cmpResult enum to have readable values for comparison results. Used by calculator, but may as well be used for e.g. strcmp

## Installation

Install the package vai composer by running:

```sh
composer require haeckel/exception
```

## Contribute

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

[Source Code](https://github.com/dhaeckel/php-basic-decimal-arithmetic)

## Support

Let us know if you have issues.

[Issue Tracker](https://github.com/dhaeckel/php-basic-decimal-arithmetic/issues)

## License

[LGPL-3.0-or-later](COPYING.LESSER)
