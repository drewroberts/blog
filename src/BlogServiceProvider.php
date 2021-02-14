<?php

declare(strict_types=1);

namespace DrewRoberts\Blog;

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
