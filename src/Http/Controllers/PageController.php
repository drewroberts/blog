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
        // If location based grand child is only child, redirect!!
        if ($grandChildPage && $grandChildPage->location_based && $grandChildPage->is_only_child) {
            return redirect(url($grandChildPage->path));
        }

        // If location based child is only child, redirect!!!
        if ($childPage && $childPage->location_based && $childPage->is_only_child) {
            return redirect(url($childPage->path));
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
