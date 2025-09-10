<?php

namespace DrewRoberts\Blog\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DrewRoberts\Blog\Blog
 */
class Blog extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DrewRoberts\Blog\Blog::class;
    }
}
