<?php

namespace DrewRoberts\Blog\Tests\Unit\Policies;

use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagePolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_pages()
    {
        $user = self::createPermissionedUser('view pages', true);

        $this->assertTrue($user->can('viewAny', Page::class));
    }

    /** @test */
    public function a_user_cannot_view_pages_without_permission()
    {
        $user = self::createPermissionedUser('view pages', false);

        $this->assertFalse($user->can('viewAny', Page::class));
    }

    /** @test */
    public function a_user_can_view_an_specific_page()
    {
        $user = self::createPermissionedUser('view pages', true);
        $page = Page::factory()->create();

        $this->assertTrue($user->can('view', $page));
    }

    /** @test */
    public function a_user_cannot_view_an_specific_page_without_permission()
    {
        $user = self::createPermissionedUser('view pages', false);
        $page = Page::factory()->create();

        $this->assertFalse($user->can('view', $page));
    }

    /** @test */
    public function a_user_can_create_a_page()
    {
        $user = self::createPermissionedUser('create pages', true);

        $this->assertTrue($user->can('create', Page::class));
    }

    /** @test */
    public function a_user_cannot_create_a_page_without_permission()
    {
        $user = self::createPermissionedUser('create pages', false);

        $this->assertFalse($user->can('create', Page::class));
    }

    /** @test */
    public function a_user_can_update_a_page()
    {
        $user = self::createPermissionedUser('update pages', true);
        $page = Page::factory()->create();

        $this->assertTrue($user->can('update', $page));
    }

    /** @test */
    public function a_user_cannot_update_a_page_without_permission()
    {
        $user = self::createPermissionedUser('update pages', false);
        $page = Page::factory()->create();

        $this->assertFalse($user->can('update', $page));
    }
}
