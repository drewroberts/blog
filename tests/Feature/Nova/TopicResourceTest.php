<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index()
    {
        Topic::factory()->count(1)->create();

        $this->actingAs(self::createPermissionedUser('view topics', true));

        $response = $this->getJson('nova-api/topics')->assertOk();

        $this->assertCount(1, $response->json('resources'));
    }
}
