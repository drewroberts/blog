<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use DrewRoberts\Blog\Models\Page;
use Illuminate\Http\Request;
use Tipoff\Support\Http\Controllers\BaseController;

class PageController extends BaseController
{
    public function __invoke(Request $request, Page $page, Page $child_page, Page $grand_child_page)
    {
        return view('blog::page', [
            'page' => $page,
            'child_page' => $child_page,
            'grand_child_page' => $grand_child_page,
        ]);
    }
}
