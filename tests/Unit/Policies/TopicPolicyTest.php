<?php

namespace DrewRoberts\Blog\Tests\Unit\Policies;

use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tipoff\Support\Contracts\Models\UserInterface;

class TopicPolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider data_provider_for_all_permissions_as_creator
     */
    public function all_permissions_as_creator(string $permission, UserInterface $user, bool $expected)
    {
        $discount = Topic::factory()->make([
            'creator_id' => $user,
        ]);

        $this->assertEquals($expected, $user->can($permission, $discount));
    }

    public function data_provider_for_all_permissions_as_creator()
    {
        return [
            'view-any-true' => [ 'viewAny', self::createPermissionedUser('view topics', true), true ],
            'view-any-false' => [ 'viewAny', self::createPermissionedUser('view topics', false), false ],
            'view-true' => [ 'view', self::createPermissionedUser('view topics', true), true ],
            'view-false' => [ 'view', self::createPermissionedUser('view topics', false), false ],
            'create-true' => [ 'create', self::createPermissionedUser('create topics', true), true ],
            'create-false' => [ 'create', self::createPermissionedUser('create topics', false), false ],
            'update-true' => [ 'update', self::createPermissionedUser('update topics', true), true ],
            'update-false' => [ 'update', self::createPermissionedUser('update topics', false), false ],
            'delete-true' => [ 'delete', self::createPermissionedUser('delete topics', true), false ],
            'delete-false' => [ 'delete', self::createPermissionedUser('delete topics', false), false ],
            'force-delete-true' => [ 'forceDelete', self::createPermissionedUser('force delete topics', true), false ],
            'force-delete-false' => [ 'forceDelete', self::createPermissionedUser('force delete topics', false), false ],
            'restore-true' => [ 'restore', self::createPermissionedUser('restore topics', true), false ],
            'restore-false' => [ 'restore', self::createPermissionedUser('restore topics', false), false ],
        ];
    }
}
