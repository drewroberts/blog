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
    public function __invoke(Request $request, Post $post, ?Series $series = null, Topic $topic = null)
    {
        if ($post->series && !$series) {
            return redirect(url($post->path));
        }

        return view('blog::post', [
            'topic' => $topic ?? $post->topic,
            'series' => $series ?? $post->series,
            'post' => $post,
        ]);
    }
}
