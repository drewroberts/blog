<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index()
    {
        Post::factory()->count(1)->create();

        $this->actingAs(self::createPermissionedUser('view posts', true));

        $response = $this->getJson('nova-api/posts')->assertOk();

        $this->assertCount(1, $response->json('resources'));
    }
}
