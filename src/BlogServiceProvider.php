<?php

declare(strict_types=1);

namespace DrewRoberts\Blog;

use Tipoff\Blog\Models\Page;
use Tipoff\Blog\Models\Post;
use Tipoff\Blog\Models\Series;
use Tipoff\Blog\Models\Topic;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class BlogServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('blog')
            ->hasConfigFile();
    }
}
