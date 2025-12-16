[![codecov](https://codecov.io/github/dhaeckel/php-exception/graph/badge.svg?token=3M3E6N9YDW)](https://codecov.io/github/dhaeckel/php-exception)
[![ci](https://github.com/dhaeckel/php-exception/actions/workflows/php.yml/badge.svg)](https://github.com/dhaeckel/php-exception/actions/workflows/php.yml)
[![Static Badge](https://img.shields.io/badge/PHPStan-level%20max-brightgreen)
](phpstan.dist.neon)
![Static Badge](https://img.shields.io/badge/PHPStan-strict_rules-brightgreen)
![Packagist License](https://img.shields.io/packagist/l/haeckel/exception)


# Haeckel/php-money

Haeckel/php-money is a php library for handling monetary values.

## Features

- [Utilities](src/Util) to make working with exceptions easier:
    - [MessageProvider](src/Util/MsgProvider.php): Provide common exception message templates to
    have consistent exception messages.

- Extensions:
    - [LogCtxAware](src/LogCtxAware): Exceptions that contain an array, to capture the context when
    the exception is thrown. This context can then be passed to a psr/log compatible logger.

## Installation

Install the package vai composer by running:

```sh
composer require haeckel/exception
```

## Contribute

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

[Source Code](https://github.com/dhaeckel/php-exception)

## Support

Let us know if you have issues.

[Issue Tracker](https://github.com/dhaeckel/php-exception/issues)

## License

[LGPL-3.0-or-later](COPYING.LESSER)
