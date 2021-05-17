<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Authorization\Models\User;

class SeriesResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        Series::factory()->count(4)->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson('nova-api/series')
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }

    /** @test */
    public function show()
    {
        $user = User::factory()->create();
        $series = Series::factory()->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson("nova-api/series/{$series->id}")
            ->assertOk();

        $this->assertEquals($series->id, $response->json('resource.id.value'));
    }

    /** @test */
    public function relatableLayouts()
    {
        $layout = Layout::factory()->create();
        $series = Series::factory()->create()->layout()->associate($layout);

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $resource = new \DrewRoberts\Blog\Nova\Series($series);
        $request = NovaRequest::create('series');
        $resource::relatableLayouts($request, $series);

        $this->assertCount(1, $resource->indexFields($request)->where('attribute', 'layout'));
    }
}
