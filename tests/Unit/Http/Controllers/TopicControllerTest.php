<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Tests\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Tests\TestCase;

class TopicControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function index_single_topic()
    {

        $topic = Topic::factory()->create();
        $series = Series::factory()->create();
        $post = Post::factory()->create();


        $prefix = config('tipoff.web.uri_prefix');

        $this->get("{$prefix}/{$topic->slug}/{$series->slug}/{$post->slug}")
            ->assertRedirect('/');
    }


}
