<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use Illuminate\Http\Request;
use DrewRoberts\Blog\Models\Post;
use Tipoff\Support\Http\Controllers\BaseController;

class PostController extends BaseController
{
    public function __invoke(Request $request, Post $post)
    {
        return redirect('/');
    }
}
