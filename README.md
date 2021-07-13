# PHP Client for ThinkOut
A PHP client library that provides a native interface to the [ThinkOut REST API](https://documenter.getpostman.com/view/6888305/TVejiVqy).

## Requirements

- [PHP](https://php.net/): >=7.4
- [Guzzle](https://github.com/guzzle/guzzle): ^6.0 || ^7.0

## Installation

The recommended way is using **[Composer](https://getcomposer.org/)**. If you don’t have Composer installed, follow the [install instructions](hhttps://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).

Once Composer is installed, execute the following command in your project root to install this library:

```sh
composer require balazscsaba2006/thinkout-client
```

Finally, include the autoloader to your project:

```php
require __DIR__ . '/vendor/autoload.php';
```

## Usage

```php
use ThinkOut\Client;

$client = new Client('username', 'password');
```

## License

👉 [LICENSE](https://github.com/balazscsaba2006/thinkout-client/blob/master/LICENSE)

## Disclaimer

The project is not created by, affiliated with, or supported by ThinkOut.