<?php

namespace DrewRoberts\Blog\Tests\Unit\Models;

use DrewRoberts\Blog\Models\Layout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use DrewRoberts\Blog\Tests\TestCase;
use Tipoff\Authorization\Models\User;

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
}