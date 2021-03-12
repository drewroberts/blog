<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\Support\Models\Image;
use Tipoff\Authorization\Models\User;
use DrewRoberts\Blog\Tests\Support\Models\Video;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;

class PageTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function it_has_a_slug()
    {
        $slug = $this->faker->slug;
        $page = Page::factory()->create(['slug' => $slug]);

        $this->assertEquals($slug, $page->slug);
    }

    /** @test */
    public function it_uses_its_slug_for_route_model_binding()
    {
        $page = Page::factory()->create();

        $this->assertEquals('slug', $page->getRouteKeyName());
    }

    /** @test */
    public function it_has_a_title()
    {
        $title = $this->faker->sentence;
        $page = Page::factory()->create(['title' => $title]);

        $this->assertEquals($title, $page->title);
    }

    /** @test */
    public function it_has_content()
    {
        $content = $this->faker->text;
        $page = Page::factory()->create(['content' => $content]);

        $this->assertEquals($content, $page->content);
    }

    /** @test */
    public function it_has_a_description()
    {
        $description = $this->faker->text;
        $page = Page::factory()->create(['description' => $description]);

        $this->assertEquals($description, $page->description);
    }

    /** @test */
    public function it_has_an_og_description()
    {
        $og_description = $this->faker->text;
        $page = Page::factory()->create(['ogdescription' => $og_description]);

        $this->assertEquals($og_description, $page->ogdescription);
    }

    /** @test */
    public function it_has_page_views()
    {
        $pageViews = $this->faker->randomNumber;
        $page = Page::factory()->create(['pageviews' => $pageViews]);

        $this->assertEquals($pageViews, $page->pageviews);
    }

    /** @test */
    public function page_views_defaults_to_zero_if_empty()
    {
        $page = Page::factory()->create(['pageviews' => null]);

        $this->assertEquals(0, $page->pageviews);
    }

    /** @test */
    public function it_has_a_published_at_date()
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf(Carbon::class, $page->published_at);
    }

    /** @test */
    public function published_at_defaults_to_now_if_empty()
    {
        $page = Page::factory()->create(['published_at' => null]);

        $this->assertNotNull($page->published_at);
    }

    /** @test */
    public function it_has_an_image_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $page = Page::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_cover/{$image->filename}",
            $page->image_path
        );
    }

    /** @test */
    public function it_uses_a_default_image_path_in_case_the_page_does_not_have_one()
    {
        $page = Page::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $page->image_path
        );
    }

    /** @test */
    public function it_has_a_placeholder_path()
    {
        config(['filesystem.disks.cloudinary.cloud_name' => 'test']);

        $image = Image::factory()->create();
        $page = Page::factory()->create(['image_id' => $image->id]);

        $this->assertEquals(
            "https://res.cloudinary.com/test/t_coverplaceholder/{$image->filename}",
            $page->placeholder_path
        );
    }

    /** @test */
    public function it_uses_a_default_placeholder_path_in_case_the_page_does_not_have_one()
    {
        $page = Page::factory()->create(['image_id' => null]);

        $this->assertStringEndsWith(
            'img/ogimage.jpg',
            $page->placeholder_path
        );
    }

    /** @test */
    public function it_tells_if_it_has_been_published()
    {
        $page = Page::factory()->create(['published_at' => now()->subHour()]);

        $this->assertTrue($page->isPublished());
    }

    /** @test */
    public function it_tells_if_it_has_not_been_published()
    {
        $page = Page::factory()->unpublished()->create();

        $this->assertFalse($page->isPublished());
    }

    /** @test */
    public function it_has_an_author()
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf(User::class, $page->author);
    }

    /** @test */
    public function the_authenticated_user_becomes_the_author_if_no_author_id_is_set()
    {
        $user = User::factory()->create();
        $this->be($user);

        $page = Page::factory()->create(['author_id' => null]);

        $this->assertNotNull($page->author);
        $this->assertEquals($user->id, $page->author_id);
    }

    /** @test */
    public function it_has_a_parent()
    {
        $parent = Page::factory()->create();
        $page = Page::factory()->create();

        $page->setParent($parent);

        $this->assertInstanceOf(Page::class, $page->parent);
    }

    /** @test */
    public function it_has_an_image()
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf(Image::class, $page->image);
    }

    /** @test */
    public function it_has_an_og_image()
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf(Image::class, $page->ogimage);
    }

    /** @test */
    public function it_has_a_video()
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf(Video::class, $page->video);
    }

    /** @test */
    public function it_keeps_track_of_who_created_it()
    {
        $user = User::factory()->create();

        $this->be($user);

        $page = Page::factory()->create();

        $this->assertInstanceOf(User::class, $page->creator);
        $this->assertEquals($user->id, $page->creator->id);
    }

    /** @test */
    public function it_keeps_track_of_who_updated_it()
    {
        $user = User::factory()->create();
        $page = Page::factory()->make();

        $this->be($user);

        $page->save();

        $this->assertInstanceOf(User::class, $page->updater);
        $this->assertEquals($user->id, $page->updater->id);
    }

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $page = Page::factory()->create();

        $page->delete();

        $this->assertSoftDeleted($page);
    }

    /** @test */
    public function it_has_a_published_global_scope()
    {
        Page::factory()->unpublished()->count(3)->create();
        $publishedPage = Page::factory()->create(['published_at' => now()->subHour()]);

        $pages = Page::all();

        $this->assertCount(1, $pages);
        $this->assertTrue($pages->contains($publishedPage));
    }
}
