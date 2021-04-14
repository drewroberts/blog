<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Controllers;

use DrewRoberts\Blog\Facade\LayoutManager;
use DrewRoberts\Blog\Models\Page;
use Illuminate\Http\Request;
use Tipoff\Support\Http\Controllers\BaseController;

class PageController extends BaseController
{
    public function __invoke(Request $request, Page $page, ?Page $childPage = null, Page $grandChildPage = null)
    {
        $leafPage = $grandChildPage ?: ($childPage ?: $page);
        if ($request->path() !== $leafPage->path) {
            return redirect(url($leafPage->path));
        }

        LayoutManager::setLayout($leafPage->layout);

        return view(LayoutManager::getViewName('blog::page.base'), [
            'page' => $page,
            'child_page' => $childPage,
            'grand_child_page' => $grandChildPage,
        ]);
    }
}
