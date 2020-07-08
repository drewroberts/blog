# Laravel package for opinionated blog implementation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/drewroberts/blog.svg?style=flat-square)](https://packagist.org/packages/drewroberts/blog)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/drewroberts/blog/run-tests?label=tests)](https://github.com/drewroberts/blog/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/drewroberts/blog.svg?style=flat-square)](https://packagist.org/packages/drewroberts/blog)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require drewroberts/blog
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="DrewRoberts\Blog\BlogServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="DrewRoberts\Blog\BlogServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

``` php
$blog = new DrewRoberts\Blog();
echo $blog->echoPhrase('Hello, DrewRoberts!');
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email package@drewroberts.com instead of using the issue tracker.

## Credits

- [Drew Roberts](https://github.com/drewroberts)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
