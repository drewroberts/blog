<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PageControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_top_level_page_no_children()
    {
        $page = Page::factory()->create([
            'is_location' => false,
        ]);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:0 GC:0 --");
    }

    /** @test */
    public function index_top_level_page_with_children()
    {
        $page = Page::factory()->create([
            'is_location' => false,
        ]);

        Page::factory()->create([
            'is_location' => false,
        ])->setParent($page);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:0 GC:0 --");
    }

    /** @test */
    public function location_based_single_child_redirects_to_parent()
    {
        $page = Page::factory()->create([
            'is_location' => true,
        ]);

        $child = Page::factory()->create([
            'is_location' => true,
        ])->setParent($page);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertRedirect('/');

        Page::factory()->create([
            'is_location' => true,
        ]);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}"))
            ->assertRedirect("/{$page->slug}");
    }

    /** @test */
    public function location_based_single_grand_child_redirects_to_parent()
    {
        $page = Page::factory()->count(2)->create([
            'is_location' => true,
        ])->first();

        $child1 = Page::factory()->create([
            'is_location' => true,
        ])->setParent($page);

        $grandChild = Page::factory()->create([
            'is_location' => true,
        ])->setParent($child1);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:0 GC:0 --");

        $this->get($this->webUrl("/{$page->slug}/{$child1->slug}/{$grandChild->slug}"))
            ->assertRedirect("/{$page->slug}");

        $child2 = Page::factory()->create([
            'is_location' => true,
        ])->setParent($page);

        $this->get($this->webUrl("/{$page->slug}/{$child1->slug}/{$grandChild->slug}"))
            ->assertRedirect("/{$page->slug}/{$child1->slug}");
    }

    /** @test */
    public function location_based_multi_child_does_not_redirect()
    {
        $page = Page::factory()->count(2)->create([
            'is_location' => true,
        ])->first();

        $child1 = Page::factory()->create([
            'is_location' => true,
        ])->setParent($page);

        $child2 = Page::factory()->create([
            'is_location' => true,
        ])->setParent($page);

        $this->get($this->webUrl("/{$page->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:0 GC:0 --");

        $this->get($this->webUrl("/{$page->slug}/{$child1->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:{$child1->id} GC:0 --");

        $this->get($this->webUrl("/{$page->slug}/{$child2->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:{$child2->id} GC:0 --");
    }

    /** @test */
    public function index_child_page_no_grand_children()
    {
        $page = Page::factory()->create();
        $child = Page::factory()->create()->setParent($page);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:{$child->id} GC:0 --");
    }

    /** @test */
    public function index_child_page_with_children()
    {
        $page = Page::factory()->create([
            'is_location' => false,
        ]);
        $child = Page::factory()->create([
            'is_location' => false,
        ])->setParent($page);

        Page::factory()->create()->setParent($child);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}"))
            ->assertOk()
            ->assertSee("-- P:{$page->id} C:{$child->id} GC:0 --");
    }

    /** @test */
    public function index_child_page_all_sequence()
    {
        $this->logToStderr();

        $page = Page::factory()->create([
            'is_location' => false,
        ]);
        $child = Page::factory()->create([
            'is_location' => false,
        ])->setParent($page);

        $segments = [$page->slug, $child->slug];
        foreach ($segments as $slug1) {
            $status = ($slug1 === $page->slug) ? 200 : 404;
            $this->get($this->webUrl("/{$slug1}"))
                ->assertStatus($status);

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
        $page = Page::factory()->create([
            'is_location' => false,
        ]);
        $child = Page::factory()->create([
            'is_location' => false,
        ])->setParent($page);
        $grandChild = Page::factory()->create([
            'is_location' => false,
        ])->setParent($child);

        $this->get($this->webUrl("/{$page->slug}/{$child->slug}/{$grandChild->slug}"))
            ->assertOk()
            ->assertSee("P:{$page->id} C:{$child->id} GC:{$grandChild->id}");
    }

    /** @test */
    public function index_grand_child_page_all_sequence()
    {
        $page = Page::factory()->create([
            'is_location' => false,
        ]);
        $child = Page::factory()->create([
            'is_location' => false,
        ])->setParent($page);
        $grandChild = Page::factory()->create([
            'is_location' => false,
        ])->setParent($child);

        $segments = [$page->slug, $child->slug, $grandChild->slug];
        foreach ($segments as $slug1) {
            $status = ($slug1 === $page->slug) ? 200 : 404;
            $this->get($this->webUrl("/{$slug1}"))
                ->assertStatus($status);

            foreach ($segments as $slug2) {
                $status = ($slug1 === $page->slug && $slug2 === $child->slug) ? 200 : 404;
                $this->get($this->webUrl("/{$slug1}/{$slug2}"))
                    ->assertStatus($status);

                foreach ($segments as $slug3) {
                    $status = ($slug1 === $page->slug && $slug2 === $child->slug && $slug3 === $grandChild->slug) ? 200 : 404;
                    $this->get($this->webUrl("/{$slug1}/{$slug2}/{$slug3}"))
                        ->assertStatus($status);
                }
            }
        }
    }
}
