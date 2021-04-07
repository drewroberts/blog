<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PageControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_top_level_page_no_children()
    {
        $page = Page::factory()->create();

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertOk()
            ->assertSee("Page: {$page->name}")
            ->assertSee("Child: NONE")
            ->assertSee("Grand Child: NONE");
    }

    /** @test */
    public function index_top_level_page_with_children()
    {
        $page = Page::factory()->create();

        Page::factory()->create()->setParent($page);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertStatus(404);
    }

    /** @test */
    public function index_top_level_page_with_topic()
    {
        $page = Page::factory()->create();
        Topic::factory()->create([
            'slug' => $page->slug,
        ]);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertStatus(200)
            ->assertDontSee("Page: {$page->name}");     // Topic has priority!
    }

    /** @test */
    public function index_child_page_no_grand_children()
    {
        $page = Page::factory()->create();
        $child = Page::factory()->create()->setParent($page);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}"))
            ->assertOk()
            ->assertSee("Page: {$page->name}")
            ->assertSee("Child: {$child->name}")
            ->assertSee("Grand Child: NONE");
    }

    /** @test */
    public function index_child_page_with_children()
    {
        $page = Page::factory()->create();
        $child = Page::factory()->create()->setParent($page);

        Page::factory()->create()->setParent($child);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}"))
            ->assertStatus(404);
    }

    /** @test */
    public function index_child_page_all_sequence()
    {
        $page = Page::factory()->create();
        $child = Page::factory()->create()->setParent($page);

        $segments = [$page->slug, $child->slug];
        foreach($segments as $slug1) {
            $this->get($this->webUrl("/{$slug1}"))
                ->assertStatus(404);

            foreach ($segments as $slug2) {
                $status = ($slug1 === $page->slug && $slug2 === $child->slug) ? 200 : 404;
                $this->get($this->webUrl("/{$slug1}/{$slug2}"))
                    ->assertStatus($status);
            }
        }
    }

    /** @test */
    public function index_grand_child_page()
    {
        $page = Page::factory()->create();
        $child = Page::factory()->create()->setParent($page);
        $grandChild = Page::factory()->create()->setParent($child);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}/{$grandChild->slug}"))
            ->assertOk()
            ->assertSee("Page: {$page->name}")
            ->assertSee("Child: {$child->name}")
            ->assertSee("Grand Child: {$grandChild->name}");
    }

    /** @test */
    public function index_grand_child_page_all_sequence()
    {
        $page = Page::factory()->create();
        $child = Page::factory()->create()->setParent($page);
        $grandChild = Page::factory()->create()->setParent($child);

        $segments = [$page->slug, $child->slug, $grandChild->slug];
        foreach($segments as $slug1) {
            $this->get($this->webUrl("/{$slug1}"))
                ->assertStatus(404);

            foreach ($segments as $slug2) {
                $this->get($this->webUrl("/{$slug1}/{$slug2}"))
                    ->assertStatus(404);

                foreach ($segments as $slug3) {
                    $status = ($slug1 === $page->slug && $slug2 === $child->slug && $slug3 === $grandChild->slug) ? 200 : 404;
                    $this->get($this->webUrl("/{$slug1}/{$slug2}/{$slug3}"))
                        ->assertStatus($status);
                }
            }
        }
    }
}
