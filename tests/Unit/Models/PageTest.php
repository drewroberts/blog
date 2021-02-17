<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\Support\Models\Image;
use DrewRoberts\Blog\Tests\Support\Models\User;
use DrewRoberts\Blog\Tests\Support\Models\Video;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_an_author()
    {
        $page = Page::factory()->create();

        $this->assertInstanceOf(User::class, $page->author);
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
}
