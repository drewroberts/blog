<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use DrewRoberts\Media\Models\Image;
use DrewRoberts\Media\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Carbon;
use Tipoff\Authorization\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function it_has_a_slug()
    {
        $slug = $this->faker->slug;
        $post = Post::factory()->create(['slug' => $slug]);

        $this->assertEquals($slug, $post->slug);
    }

    /** @test */
    public function it_uses_its_slug_for_route_model_binding()
    {
        $post = Post::factory()->create();

        $this->assertEquals('slug', $post->getRouteKeyName());
    }

    /** @test */
    public function it_has_a_path()
    {
        $post = Post::factory()->create();

        $this->assertEquals(
            "/{$post->topic->slug}/{$post->series->slug}/{$post->slug}",
            $post->path
        );
    }

    /** @test */
    public function it_has_a_title()
    {
        $title = $this->faker->sentence;
        $post = Post::factory()->create(['title' => $title]);

        $this->assertEquals($title, $post->title);
    }

    /** @test */
    public function it_has_content()
    {
        $content = $this->faker->text;
        $post = Post::factory()->create(['content' => $content]);

        $this->assertEquals($content, $post->content);
    }

    /** @test */
    public function it_has_html_content()
    {
        $content = $this->faker->text;
        $post = Post::factory()->create(['content' => $content]);

        $this->assertEquals(Markdown::parse($content), $post->html_content);
    }

    /** @test */
    public function it_has_a_description()
    {
        $description = $this->faker->text;
        $post = Post::factory()->create(['description' => $description]);

        $this->assertEquals($description, $post->description);
    }

    /** @test */
    public function it_has_an_og_description()
    {
        $og_description = $this->faker->text;
        $post = Post::factory()->create(['ogdescription' => $og_description]);

        $this->assertEquals($og_description, $post->ogdescription);
    }

    /** @test */
    public function it_has_page_views()
    {
        $pageViews = $this->faker->randomNumber;
        $post = Post::factory()->create(['pageviews' => $pageViews]);

        $this->assertEquals($pageViews, $post->pageviews);
    }

    /** @test */
    public function page_views_defaults_to_zero_if_empty()
    {
        $post = Post::factory()->create(['pageviews' => null]);

        $this->assertEquals(0, $post->pageviews);
    }

    /** @test */
    public function it_has_a_published_at_date()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Carbon::class, $post->published_at);
    }

    /** @test */
    public function published_at_defaults_to_now_if_empty()
    {
        $post = Post::factory()->create(['published_at' => null]);

        $this->assertNotNull($post->published_at);
    }

    /** @test */
    public function it_keeps_track_of_who_created_it()
    {
        $user = User::factory()->create();

        $this->be($user);

        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->creator);
        $this->assertEquals($user->id, $post->creator->id);
    }

    /** @test */
    public function it_keeps_track_of_who_updated_it()
    {
        $user = User::factory()->create();
        $post = Post::factory()->make();

        $this->be($user);

        $post->save();

        $this->assertInstanceOf(User::class, $post->updater);
        $this->assertEquals($user->id, $post->updater->id);
    }

    /** @test */
    public function it_has_an_image_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $post = Post::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_cover/{$image->filename}",
            $post->image_path
        );
    }

    /** @test */
    public function it_uses_a_default_image_path_in_case_the_page_does_not_have_one()
    {
        $post = Post::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $post->image_path
        );
    }

    /** @test */
    public function it_has_a_placeholder_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $post = Post::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_coverplaceholder/{$image->filename}",
            $post->placeholder_path
        );
    }

    /** @test */
    public function it_uses_a_default_placeholder_path_in_case_the_page_does_not_have_one()
    {
        $post = Post::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $post->placeholder_path
        );
    }

    /** @test */
    public function it_belongs_to_a_topic()
    {
        $topic = Topic::factory()->create();
        $post = Post::factory()->create(['topic_id' => $topic->id]);

        $this->assertInstanceOf(Topic::class, $post->topic);
    }

    /** @test */
    public function it_uses_the_series_topic_if_topic_id_is_not_set()
    {
        $topic = Topic::factory()->create();
        $series = Series::factory()->create(['topic_id' => $topic->id]);

        $post = Post::factory()->create([
            'series_id' => $series->id,
            'topic_id' => null,
        ]);

        $this->assertNotNull($post->topic);
        $this->assertEquals($topic->id, $post->topic_id);
    }

    /** @test */
    public function it_belongs_to_a_series()
    {
        $series = Series::factory()->create();
        $post = Post::factory()->create(['series_id' => $series->id]);

        $this->assertInstanceOf(Series::class, $post->series);
    }

    /** @test */
    public function it_has_an_author()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->author);
    }

    /** @test */
    public function the_authenticated_user_becomes_the_author_if_no_author_id_is_set()
    {
        $user = User::factory()->create();
        $this->be($user);

        $post = Post::factory()->create(['author_id' => null]);

        $this->assertNotNull($post->author);
        $this->assertEquals($user->id, $post->author_id);
    }

    /** @test */
    public function it_has_an_image()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Image::class, $post->image);
    }

    /** @test */
    public function it_has_an_og_image()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Image::class, $post->ogimage);
    }

    /** @test */
    public function it_has_a_video()
    {
        $post = Post::factory()->create();

        $this->assertInstanceOf(Video::class, $post->video);
    }

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $post = Post::factory()->create();

        $post->delete();

        $this->assertSoftDeleted($post);
    }

    /** @test */
    public function it_tells_if_it_has_been_published()
    {
        $post = Post::factory()->create(['published_at' => now()->subHour()]);

        $this->assertTrue($post->isPublished());
    }

    /** @test */
    public function it_tells_if_it_has_not_been_published()
    {
        $post = Post::factory()->unpublished()->create();

        $this->assertFalse($post->isPublished());
    }

    /** @test */
    public function it_has_a_published_global_scope()
    {
        Post::factory()->unpublished()->count(3)->create();
        $publishedPost = Post::factory()->create(['published_at' => now()->subHour()]);

        $posts = Post::all();

        $this->assertCount(1, $posts);
        $this->assertTrue($posts->contains($publishedPost));
    }

    /** @test */
    public function path_with_series()
    {
        $post = Post::factory()->create();

        $this->assertStringNotContainsString('blog', $post->path);
    }

    /** @test */
    public function path_without_series()
    {
        $post = Post::factory()->create([
            'series_id' => null,
        ]);

        $this->assertStringStartsWith('/blog', $post->path);
    }
}
