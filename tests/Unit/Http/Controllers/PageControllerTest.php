<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;

class PageControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_single_page()
    {
        $page = Page::factory()->create();

        $child_page = Page::factory()->create();
        $child_page->setParent($page);

        $grand_child_page = Page::factory()->create();
        $grand_child_page->setParent($child_page);

        $this->get($this->webUrl("/blog/{$page->slug}/{$child_page->slug}/{$grand_child_page->slug}"))
            ->assertOk()
            ->assertSee($page->name)
            ->assertSee($child_page->name)
            ->assertSee($grand_child_page->name);
    }
}
