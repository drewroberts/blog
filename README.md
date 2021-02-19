# Laravel package for opinionated blog implementation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/drewroberts/blog.svg?style=flat-square)](https://packagist.org/packages/drewroberts/blog)
![Tests](https://github.com/drewroberts/blog/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/drewroberts/blog.svg?style=flat-square)](https://packagist.org/packages/drewroberts/blog)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require drewroberts/blog
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

The migrations will run from the package. You can extend the Models from the package if you need additional classes or functions added to them. 

### Registering the Nova resources

If you would like to use the Nova resources included with this package, you need to register it manually in your `NovaServiceProvider` in the `boot` method.

```php
Nova::resources([
    \DrewRoberts\Media\Nova\Image::class,
    \DrewRoberts\Media\Nova\Tag::class,
    \DrewRoberts\Media\Nova\Video::class,
    \DrewRoberts\Blog\Nova\Series::class,
    \DrewRoberts\Blog\Nova\Topic::class,
    \DrewRoberts\Blog\Nova\Page::class,
    \DrewRoberts\Blog\Nova\Post::class,
]);
```

## Models

We include the following models in this package:

**List of Models**

- Page
- Post
- Series
- Topic

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email packages@drewroberts.com instead of using the issue tracker.

## Credits

- [Drew Roberts](https://github.com/drewroberts)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
