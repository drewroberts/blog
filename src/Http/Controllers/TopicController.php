<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use Illuminate\Http\Request;
use DrewRoberts\Blog\Models\Topic;
use Tipoff\Support\Http\Controllers\BaseController;

class TopicController extends BaseController
{
    public function __invoke(Request $request, Topic $topic)
    {
        return redirect('/');
    }
}
