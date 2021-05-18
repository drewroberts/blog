<?php

namespace DrewRoberts\Blog\Tests\Unit\Policies;

use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tipoff\Support\Contracts\Models\UserInterface;

class SeriesPolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $discount = Series::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $discount));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-any-true' => [ 'viewAny', self::createPermissionedUser('view series', true), true ],
            'view-any-false' => [ 'viewAny', self::createPermissionedUser('view series', false), false ],
            'view-true' => [ 'view', self::createPermissionedUser('view series', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view series', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create series', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create series', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update series', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update series', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete series', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete series', false), false ],
            'force-delete-true' => [ 'forceDelete', self::createPermissionedUser('force delete series', true), false ],
            'force-delete-false' => [ 'forceDelete', self::createPermissionedUser('force delete series', false), false ],
            'restore-true' => [ 'restore', self::createPermissionedUser('restore series', true), false ],
            'restore-false' => [ 'restore', self::createPermissionedUser('restore series', false), false ],
        ];
    }
}
