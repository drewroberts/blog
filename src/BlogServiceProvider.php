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
                \DrewRoberts\Blog\Nova\Page::class,
                \DrewRoberts\Blog\Nova\Post::class,
                \DrewRoberts\Blog\Nova\Series::class,
                \DrewRoberts\Blog\Nova\Topic::class,
            ])
            ->name('blog');
    }
}
