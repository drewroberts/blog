<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class TopicResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index()
    {
        Config::set('app.key', 'base64:CA0WFs+ECA4gq/G95GpRwEaYsoNdUF0cAziYkc83ISE=');
        
        Topic::factory()->count(1)->create();

        $this->actingAs(self::createPermissionedUser('view topics', true));

        $response = $this->getJson('nova-api/topics')->assertOk();

        $this->assertCount(1, $response->json('resources'));
    }
}
