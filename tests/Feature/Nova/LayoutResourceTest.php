<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Nova\Filters\Filter;
use Tipoff\Authorization\Models\User;

class LayoutResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson('nova-api/layouts')
            ->assertOk();

        $this->assertCount(Layout::count(), $response->json('resources'));
    }

    /** @test */
    public function show()
    {
        $page = Layout::factory()->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson("nova-api/layouts/{$page->id}")
            ->assertOk();

        $this->assertEquals($page->id, $response->json('resource.id.value'));
    }

    /** @test */
    public function filtersForALayouts()
    {
        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->withExceptionHandling()
            ->get('/nova-api/layouts/filters');

        $response->assertStatus(200);

        $this->assertInstanceOf(Filter::class, $response->original[0]);
    }
}
