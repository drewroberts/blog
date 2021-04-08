<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TopicControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_proper_linkage()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create([
            'topic_id' => $topic,
        ]);
        $post = Post::factory()->create([
            'series_id' => $series,
        ]);

        $this->get($this->webUrl("/{$topic->slug}"))
            ->assertOk()
            ->assertSee("Topic: {$topic->name}")
            ->assertDontSee("Series: {$series->name}")
            ->assertDontSee("Post: {$post->name}");
    }
}
