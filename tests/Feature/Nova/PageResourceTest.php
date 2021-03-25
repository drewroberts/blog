<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Authorization\Models\User;

class PageResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        Page::factory()->count(4)->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson('nova-api/pages')
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }

    /** @test */
    public function show()
    {
        $user = User::factory()->create();
        $page = Page::factory()->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson("nova-api/pages/{$page->id}")
            ->assertOk();

        $this->assertEquals($note->id, $response->json('resource.id.value'));
    }
}
