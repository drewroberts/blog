<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit;

use DrewRoberts\Blog\Facade\LayoutManager;
use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;

class LayoutManagerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function can_log_error_if_view_doesnt_exist() {
        $layout = Layout::factory()->create();
        LayoutManager::setLayout($layout);

        Log::shouldReceive('error')
            ->with('Layout view does not exist: ' . LayoutManager::getLayout()->view);

        $view = LayoutManager::getViewName('example');
        $this->assertEquals('example', $view);
    }


}
