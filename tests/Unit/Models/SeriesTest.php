<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Media\Models\Image;
use Tipoff\Authorization\Models\User;
use DrewRoberts\Media\Models\Video;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;

class SeriesTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function it_has_a_slug()
    {
        $slug = $this->faker->slug;
        $series = Series::factory()->create(['slug' => $slug]);

        $this->assertEquals($slug, $series->slug);
    }

    /** @test */
    public function it_uses_its_slug_for_route_model_binding()
    {
        $series = Series::factory()->create();

        $this->assertEquals('slug', $series->getRouteKeyName());
    }

    /** @test */
    public function it_has_a_path()
    {
        $series = Series::factory()->create();

        $this->assertEquals(
            "/{$series->topic->slug}/{$series->slug}",
            $series->path
        );
    }

    /** @test */
    public function it_has_a_title()
    {
        $title = $this->faker->sentence;
        $series = Series::factory()->create(['title' => $title]);

        $this->assertEquals($title, $series->title);
    }

    /** @test */
    public function it_has_content()
    {
        $content = $this->faker->paragraph;
        $series = Series::factory()->create(['content' => $content]);

        $this->assertEquals($content, $series->content);
    }

    /** @test */
    public function it_has_notes()
    {
        $note = $this->faker->sentence;
        $series = Series::factory()->create(['note' => $note]);

        $this->assertEquals($note, $series->note);
    }

    /** @test */
    public function it_has_a_description()
    {
        $description = $this->faker->sentence;
        $series = Series::factory()->create(['description' => $description]);

        $this->assertEquals($description, $series->description);
    }

    /** @test */
    public function it_has_an_og_description()
    {
        $og_description = $this->faker->sentence;
        $series = Series::factory()->create(['ogdescription' => $og_description]);

        $this->assertEquals($og_description, $series->ogdescription);
    }

    /** @test */
    public function it_has_page_views()
    {
        $pageViews = $this->faker->randomNumber;
        $series = Series::factory()->create(['pageviews' => $pageViews]);

        $this->assertEquals($pageViews, $series->pageviews);
    }

    /** @test */
    public function page_views_defaults_to_zero_if_empty()
    {
        $series = Series::factory()->create(['pageviews' => null]);

        $this->assertEquals(0, $series->pageviews);
    }

    /** @test */
    public function it_has_an_image_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $series = Series::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_cover/{$image->filename}",
            $series->image_path
        );
    }

    /** @test */
    public function it_uses_a_default_image_path_in_case_the_page_does_not_have_one()
    {
        $series = Series::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $series->image_path
        );
    }

    /** @test */
    public function it_has_a_placeholder_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $series = Series::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_coverplaceholder/{$image->filename}",
            $series->placeholder_path
        );
    }

    /** @test */
    public function it_uses_a_default_placeholder_path_in_case_the_page_does_not_have_one()
    {
        $series = Series::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $series->placeholder_path
        );
    }

    /** @test */
    public function it_belongs_to_a_topic()
    {
        $series = Series::factory()->create();

        $this->assertInstanceOf(Topic::class, $series->topic);
    }

    /** @test */
    public function it_has_posts()
    {
        $series = Series::factory()->create();
        Post::factory()->create(['series_id' => $series->id]);

        $this->assertInstanceOf(Collection::class, $series->posts);
        $this->assertInstanceOf(Post::class, $series->posts->first());
    }

    /** @test */
    public function it_has_an_image()
    {
        $series = Series::factory()->create();

        $this->assertInstanceOf(Image::class, $series->image);
    }

    /** @test */
    public function it_has_an_og_image()
    {
        $series = Series::factory()->create();

        $this->assertInstanceOf(Image::class, $series->ogimage);
    }

    /** @test */
    public function it_has_a_video()
    {
        $series = Series::factory()->create();

        $this->assertInstanceOf(Video::class, $series->video);
    }

    /** @test */
    public function it_keeps_track_of_who_created_it()
    {
        $user = User::factory()->create();

        $this->be($user);

        $series = Series::factory()->create();

        $this->assertInstanceOf(User::class, $series->creator);
        $this->assertEquals($user->id, $series->creator->id);
    }

    /** @test */
    public function it_keeps_track_of_who_updated_it()
    {
        $user = User::factory()->create();
        $series = Series::factory()->make();

        $this->be($user);

        $series->save();

        $this->assertInstanceOf(User::class, $series->updater);
        $this->assertEquals($user->id, $series->updater->id);
    }
}
