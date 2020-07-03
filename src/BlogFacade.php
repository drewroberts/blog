<?php

namespace DrewRoberts\Blog;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DrewRoberts\Blog\Blog
 */
class BlogFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'blog';
    }
}
