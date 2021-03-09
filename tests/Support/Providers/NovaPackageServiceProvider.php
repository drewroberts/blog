<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Support\Providers;

use DrewRoberts\Blog\Nova\Page;
use DrewRoberts\Blog\Nova\Post;
use DrewRoberts\Blog\Nova\Series;
use DrewRoberts\Blog\Nova\Video;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Page::class,
        Post::class,
        Series::class,
        Video::class,
    ];
}
