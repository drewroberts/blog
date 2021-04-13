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
        if ($grandChildPage) {
            if ($grandChildPage->location_based && $grandChildPage->is_only_child) {
                return redirect(url($grandChildPage->path));
            }
        } elseif ($childPage) {
            // If location based child is only child, redirect!!!
            if ($childPage->location_based && $childPage->is_only_child) {
                return redirect(url($childPage->path));
            }
        } else {
            // If there is only  location based root page, redirect home!
            if ($page->is_only_root_location) {
                return redirect(url($page->path));
            }
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
