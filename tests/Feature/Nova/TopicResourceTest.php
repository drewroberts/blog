<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Authorization\Models\User;

class TopicResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        Topic::factory()->count(4)->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson('nova-api/topics')
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }

    /** @test */
    public function show()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson("nova-api/topics/{$topic->id}")
            ->assertOk();

        $this->assertEquals($topic->id, $response->json('resource.id.value'));
    }

    /** @test */
    public function relatableLayouts()
    {
        $layout = Layout::factory()->create();
        $topic = Topic::factory()->create()->layout()->associate($layout);

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $resource = new \DrewRoberts\Blog\Nova\Topic($topic);
        $request = NovaRequest::create('topics');
        $resource::relatableLayouts($request, $topic);

        $this->assertCount(1, $resource->indexFields($request)->where('attribute', 'layout'));
    }
}
