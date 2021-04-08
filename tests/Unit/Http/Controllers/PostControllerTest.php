<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostControllerTest extends TestCase
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

        $this->get($this->webUrl("/{$topic->slug}/{$series->slug}/{$post->slug}"))
            ->assertOk()
            ->assertSee("Topic: {$topic->name}")
            ->assertSee("Series: {$series->name}")
            ->assertSee("Post: {$post->name}");
    }

    /** @test */
    public function index_post_with_no_series()
    {
        $post = Post::factory()->create([
            'topic_id' => null,
            'series_id' => null,
        ]);

        $this->get($this->webUrl("/blog/{$post->slug}"))
            ->assertOk()
            ->assertSee("Topic: NONE")
            ->assertSee("Series: NONE")
            ->assertSee("Post: {$post->name}");
    }

    /** @test */
    public function index_post_with_series_redirects()
    {
        $post = Post::factory()->create();

        $this->get($this->webUrl("/blog/{$post->slug}"))
            ->assertRedirect(url($post->path));
    }

    /** @test */
    public function index_post_has_bad_series()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create([
            'topic_id' => $topic,
        ]);
        $post = Post::factory()->create([
            'series_id' => Series::factory()->create(),
        ]);

        $this->get($this->webUrl("/{$topic->slug}/{$series->slug}/{$post->slug}"))
            ->assertStatus(404);
    }

    /** @test */
    public function index_series_has_bad_topic()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create([
            'topic_id' => Topic::factory()->create(),
        ]);
        $post = Post::factory()->create([
            'series_id' => $series,
        ]);

        $this->get($this->webUrl("/{$topic->slug}/{$series->slug}/{$post->slug}"))
            ->assertStatus(404);
    }
}
