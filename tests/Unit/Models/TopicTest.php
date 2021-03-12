<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\Support\Models\Image;
use Tipoff\Authorization\Models\User;
use DrewRoberts\Blog\Tests\Support\Models\Video;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;

class TopicTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function it_has_a_slug()
    {
        $slug = $this->faker->slug;
        $topic = Topic::factory()->create(['slug' => $slug]);

        $this->assertEquals($slug, $topic->slug);
    }

    /** @test */
    public function it_uses_its_slug_for_route_model_binding()
    {
        $topic = Topic::factory()->create();

        $this->assertEquals('slug', $topic->getRouteKeyName());
    }

    /** @test */
    public function it_has_a_path()
    {
        $topic = Topic::factory()->create();

        $this->assertEquals(
            "/{$topic->slug}",
            $topic->path
        );
    }

    /** @test */
    public function it_has_a_title()
    {
        $title = $this->faker->sentence;
        $page = Topic::factory()->create(['title' => $title]);

        $this->assertEquals($title, $page->title);
    }

    /** @test */
    public function it_has_content()
    {
        $content = $this->faker->paragraph;
        $page = Topic::factory()->create(['content' => $content]);

        $this->assertEquals($content, $page->content);
    }

    /** @test */
    public function it_has_a_description()
    {
        $description = $this->faker->sentence;
        $page = Topic::factory()->create(['description' => $description]);

        $this->assertEquals($description, $page->description);
    }

    /** @test */
    public function it_has_a_og_description()
    {
        $og_description = $this->faker->sentence;
        $page = Topic::factory()->create(['ogdescription' => $og_description]);

        $this->assertEquals($og_description, $page->ogdescription);
    }

    /** @test */
    public function it_has_notes()
    {
        $note = $this->faker->sentence;
        $page = Topic::factory()->create(['note' => $note]);

        $this->assertEquals($note, $page->note);
    }

    /** @test */
    public function it_has_page_views()
    {
        $pageViews = $this->faker->randomNumber;
        $topic = Topic::factory()->create(['pageviews' => $pageViews]);

        $this->assertEquals($pageViews, $topic->pageviews);
    }

    /** @test */
    public function page_views_defaults_to_zero_if_empty()
    {
        $topic = Topic::factory()->create(['pageviews' => null]);

        $this->assertEquals(0, $topic->pageviews);
    }

    /** @test */
    public function it_has_an_image_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $topic = Topic::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_cover/{$image->filename}",
            $topic->image_path
        );
    }

    /** @test */
    public function it_uses_a_default_image_path_in_case_the_page_does_not_have_one()
    {
        $topic = Topic::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $topic->image_path
        );
    }

    /** @test */
    public function it_has_a_placeholder_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $topic = Topic::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_coverplaceholder/{$image->filename}",
            $topic->placeholder_path
        );
    }

    /** @test */
    public function it_uses_a_default_placeholder_path_in_case_the_page_does_not_have_one()
    {
        $topic = Topic::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $topic->placeholder_path
        );
    }

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
