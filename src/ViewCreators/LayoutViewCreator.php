<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\ViewCreators;

use DrewRoberts\Blog\LayoutManager;
use Illuminate\Contracts\View\View;

class LayoutViewCreator
{
    private $layoutManager;

    public function __construct(LayoutManager $layoutManager)
    {
        $this->layoutManager = $layoutManager;
    }

    public function create(View $view)
    {
        $view->with([
            'layoutName' => $this->layoutManager->getLayoutName(),
            'layout' => $this->layoutManager->getLayout(),
        ]);
    }
}
