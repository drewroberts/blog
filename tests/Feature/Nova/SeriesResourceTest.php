<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Feature\Nova;

use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index()
    {
        Series::factory()->count(1)->create();

        $this->actingAs(self::createPermissionedUser('view series', true));

        $response = $this->getJson('nova-api/series')->assertOk();

        $this->assertCount(1, $response->json('resources'));
    }
}
