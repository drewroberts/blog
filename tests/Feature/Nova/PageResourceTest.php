<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

class PageResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index()
    {
        Config::set('app.key', 'base64:CA0WFs+ECA4gq/G95GpRwEaYsoNdUF0cAziYkc83ISE=');

        Page::factory()->count(1)->create();

        $this->actingAs(self::createPermissionedUser('view pages', true));

        $response = $this->getJson('nova-api/pages')->assertOk();

        $this->assertCount(1, $response->json('resources'));
    }
}
