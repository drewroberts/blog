<?php

declare(strict_types=1);

namespace DrewRoberts\Blog;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Policies\PagePolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class BlogServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Page::class => PagePolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Locations\Nova\Page::class,
                \Tipoff\Locations\Nova\Post::class,
                \Tipoff\Locations\Nova\Series::class,
                \Tipoff\Locations\Nova\Topic::class,
            ])
            ->name('blog');
    }
}
