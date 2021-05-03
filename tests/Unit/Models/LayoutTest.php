<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class LayoutTest extends TestCase
{
    use RefreshDatabase,
    WithFaker;

    /** @test */
    public function create_layout()
    {
        $name = $this->faker->name;
        $layout = Layout::factory()->create(['name' => $name]);

        $this->assertEquals($name, $layout->name);
    }

    /** @test */
    public function get_posts()
    {
        $layout = Layout::factory()->create();
        $post = Post::factory()->create(['layout_id' => $layout->id]);

        $this->assertInstanceOf(HasMany::class, $layout->posts());
        $this->assertEquals($post->getForeignKey(), $layout->posts()->first()->getForeignKey());
        $this->assertEquals('layouts.id', $layout->posts()->getQualifiedParentKeyName());

        $this->assertEquals($layout->id, $post->layout->id);
        $this->assertEquals($layout->name, $post->layout->name);
    }

    /** @test */
    public function get_pages()
    {
        $layout = Layout::factory()->create();
        $page = Page::factory()->create(['layout_id' => $layout->id]);

        $this->assertInstanceOf(HasMany::class, $layout->pages());
        $this->assertEquals($page->getForeignKey(), $layout->pages()->first()->getForeignKey());
        $this->assertEquals('layouts.id', $layout->pages()->getQualifiedParentKeyName());

        $this->assertEquals($layout->id, $page->layout->id);
        $this->assertEquals($layout->name, $page->layout->name);
    }
}
