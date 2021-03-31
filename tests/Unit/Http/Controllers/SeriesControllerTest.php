<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Tests\TestCase;

class SeriesControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_single_series()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create();

        $this->get($this->webUrl("/blog/{$topic->slug}/{$series->slug}"))
            ->assertOk()
            ->assertSee($topic->name)
            ->assertSee($series->name);
    }
}
