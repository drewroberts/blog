<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddBlogPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
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
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}
