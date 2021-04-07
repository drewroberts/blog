<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Tests\TestCase;

class PostControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_single_post()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create();
        $post = Post::factory()->create();

        $this->get($this->webUrl("/blog/{$topic->slug}/{$series->slug}/{$post->slug}"))
            ->assertOk()
            ->assertSee($topic->name)
            ->assertSee($series->name)
            ->assertSee($post->name);
    }
}
