<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use Illuminate\Http\Request;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Post;
use Tipoff\Support\Http\Controllers\BaseController;

class PostController extends BaseController
{
    public function __invoke(Request $request, Topic $topic, Series $series, Post $post)
    {
        return view('blog::post', [
            'topic' => $topic,
            'series' => $series,
            'post' => $post
        ]);
    }
}
