# MAX 

[![API MAX](https://img.shields.io/badge/Official_API_doc-MAX-8f3fff?logo=message-square&style=flat-square)](https://dev.max.ru/docs)

[![Laravel](https://img.shields.io/badge/LaravelPackage-available-success?logo=laravel&style=flat-square)](https://github.com/VioletSun/MAX)
[![Laravel versions](https://badge.laravel.cloud/badge/wendelladriel/laravel-expressive?style=flat)](https://github.com/VioletSun/MAX)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![PHP version](https://img.shields.io/badge/php-8.2-3wefg3.svg?style=flat-square)](https://github.com/VioletSun/MAX)
[![Total Downloads][ico-downloads]][link-downloads]
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/VioletSun/MAX)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

[![Project Status](https://img.shields.io/badge/Status-In%20development-orange.svg)](https://github.com/VioletSun/MAX/blob/main/TODO.md)

## Installation

Via Composer
```bash
composer require violetsun/max
```

Package vendor publish
```bash
php artisan vendor:publish --provider="VioletSun\MAX\MAXServiceProvider"
```
or
```bash
php artisan vendor:publish --tag=max-config
php artisan vendor:publish --tag=max-migrations
```

Migrations (after vendor publish)
```bash
php artisan migrate
```

.env
```bash
MAX_API_KEY="YOUR_MAX_API_KEY"
```

## Usage

**Send a message**

```php
MAX::sendMessage(
    1234567890, 
    [
        'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'
        // there will be more to come...
    ]
);
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

```bash
composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email demettriss@gmail.com instead of using the issue tracker.

## Credits

- [demettriss][link-author]
- [All Contributors][link-contributors]

## License

[license file](LICENSE)

[ico-version]: https://img.shields.io/packagist/v/violetsun/max.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/violetsun/max.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/violetsun/max/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/violetsun/max
[link-downloads]: https://packagist.org/packages/violetsun/max
[link-travis]: https://travis-ci.org/violetsun/max
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/violetsun
[link-contributors]: ../../contributors
