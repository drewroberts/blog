<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TopicControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_single_topic()
    {
        $topic = Topic::factory()->create();

        $this->get($this->webUrl("/blog/{$topic->slug}"))
            ->assertOk()
            ->assertSee($topic->name);
    }
}
