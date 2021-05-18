<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Nova\Http\Requests\NovaRequest;
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

        $this->assertEquals($page->id, $response->json('resource.id.value'));
    }

    /** @test */
    public function relatableLayouts()
    {
        $layout = Layout::factory()->create();
        $page = Page::factory()->create()->layout()->associate($layout);

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $resource = new \DrewRoberts\Blog\Nova\Page($page);
        $request = NovaRequest::create('pages');
        $resource::relatableLayouts($request, $page);

        $this->assertCount(1, $resource->indexFields($request)->where('attribute', 'layout'));
    }
}
