<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use Illuminate\Http\Request;
use DrewRoberts\Blog\Models\Page;
use Tipoff\Support\Http\Controllers\BaseController;

class PageController extends BaseController
{
    public function __invoke(Request $request, Page $page)
    {
        return redirect(route('page', ['page' => $page]));
    }
}
