<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use Illuminate\Http\Request;
use Tipoff\Support\Http\Controllers\BaseController;

class PostController extends BaseController
{
    public function __invoke(Request $request, Topic $topic, Series $series, Post $post)
    {
        return view('blog::post', [
            'topic' => $topic,
            'series' => $series,
            'post' => $post,
        ]);
    }
}
