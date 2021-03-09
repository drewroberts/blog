<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddBlogPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
                 'view pages',
                 'create pages',
                 'update pages',
                 'view posts',
                 'create posts',
                 'update posts',
                 'view series',
                 'create series',
                 'update series',
                 'view topics',
                 'create topics',
                 'update topics',
        ];

        $this->createPermissions($permissions);
    }
}


