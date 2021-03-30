<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Services;

use DrewRoberts\Blog\Exceptions\UnresolvedPage;
use DrewRoberts\Blog\Models\Page;

class PageResolver
{
    const TIPOFF_PAGE = 'tipoff.page';

    public static function page(): ?Page
    {
        return app()->has(self::TIPOFF_PAGE) ? app(self::TIPOFF_PAGE) : null;
    }

    public function resolve($PAGE = null): Page
    {
        $page = $page ?? static::page();
        if (! $page instanceof PAGE) {
            if (PAGE::query()->count() !== 1) {
                throw new UnresolvedPage();
            }

            $page = Page::query()->firstOrFail();
        }

        app()->instance(self::TIPOFF_PAGE, $page);

        return $page;
    }
}
