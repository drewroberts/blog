<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Nova\Http\Requests\NovaRequest;
use Tipoff\Authorization\Models\User;

class PostResourceTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index()
    {
        Post::factory()->count(4)->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson('nova-api/posts')
            ->assertOk();

        $this->assertCount(4, $response->json('resources'));
    }

    /** @test */
    public function show()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $response = $this->getJson("nova-api/posts/{$post->id}")
            ->assertOk();

        $this->assertEquals($post->id, $response->json('resource.id.value'));
    }

    /** @test */
    public function relatableLayouts()
    {
        $layout = Layout::factory()->create();
        $posts = Post::factory()->create()->layout()->associate($layout);

        $this->actingAs(User::factory()->create()->assignRole('Admin'));

        $resource = new \DrewRoberts\Blog\Nova\Post($posts);
        $request = NovaRequest::create('posts');
        $resource::relatableLayouts($request, $posts);

        $this->assertCount(1, $resource->indexFields($request)->where('attribute', 'layout'));
    }
}
