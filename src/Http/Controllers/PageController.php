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
        // If location based child is only child of parent, redirect to parent alone!!
        if ($childPage && $childPage->location_based && $page->children->count() === 1) {
            return redirect(url($page->path));
        }

        $leafPage = $grandChildPage ?: ($childPage ?: $page);
        LayoutManager::setLayout($leafPage->layout);

        return view(LayoutManager::getViewName('blog::page.base'), [
            'page' => $page,
            'child_page' => $childPage,
            'grand_child_page' => $grandChildPage,
        ]);
    }
}
