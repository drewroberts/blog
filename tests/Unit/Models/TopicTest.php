<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Tests\Support\Models\Image;
use DrewRoberts\Blog\Tests\Support\Models\User;
use DrewRoberts\Blog\Tests\Support\Models\Video;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_series()
    {
        $topic = Topic::factory()->create();
        Series::factory()->create(['topic_id' => $topic->id]);

        $this->assertInstanceOf(Collection::class, $topic->series);
        $this->assertInstanceOf(Series::class, $topic->series->first());
    }

    /** @test */
    public function it_has_posts_through_series()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create(['topic_id' => $topic->id]);
        Post::factory()->create(['series_id' => $series->id]);

        $this->assertInstanceOf(Collection::class, $topic->posts);
        $this->assertInstanceOf(Post::class, $topic->posts->first());
    }

    /** @test */
    public function it_has_an_image()
    {
        $image = Image::factory()->create();
        $topic = Topic::factory()->create(['image_id' => $image->id]);

        $this->assertInstanceOf(Image::class, $topic->image);
    }

    /** @test */
    public function it_has_an_og_image()
    {
        $og_image = Image::factory()->create();
        $topic = Topic::factory()->create(['ogimage_id' => $og_image->id]);

        $this->assertInstanceOf(Image::class, $topic->ogimage);
    }

    /** @test */
    public function it_has_a_video()
    {
        $video = Video::factory()->create();
        $topic = Topic::factory()->create(['video_id' => $video->id]);

        $this->assertInstanceOf(Video::class, $topic->video);
    }

    /** @test */
    public function it_keeps_track_of_who_created_it()
    {
        $user = User::factory()->create();

        $this->be($user);

        $topic = Topic::factory()->create();

        $this->assertInstanceOf(User::class, $topic->creator);
        $this->assertEquals($user->id, $topic->creator->id);
    }

    /** @test */
    public function it_keeps_track_of_who_updated_it()
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->make();

        $this->be($user);

        $topic->save();

        $this->assertInstanceOf(User::class, $topic->updater);
        $this->assertEquals($user->id, $topic->updater->id);
    }
}
