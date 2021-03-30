<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use Illuminate\Http\Request;
use DrewRoberts\Blog\Models\Series;
use Tipoff\Support\Http\Controllers\BaseController;

class SeriesController extends BaseController
{
    public function __invoke(Request $request, Series $series)
    {
        return redirect('/');
    }
}
