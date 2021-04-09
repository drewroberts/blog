<?php

declare(strict_types=1);

use Drewroberts\Blog\Models\Layout;
use Illuminate\Database\Migrations\Migration;
use Tipoff\Support\Enums\LayoutType;

class AddLayouts extends Migration
{
    public function up()
    {

        if (class_exists(Layout::class)) {
            foreach ([
                [
                    'name'          => 'Base Page',
                    'layout_type'   => LayoutType::Page,
                    'view'          => 'Blog::page.base',
                    'note'          => 'Base HTML Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'AMP Page',
                    'layout_type'   => LayoutType::Page,
                    'view'          => 'Blog::page.amp',
                    'note'          => 'AMP Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'Base Post',
                    'layout_type'   => LayoutType::Post,
                    'view'          => 'Blog::post.base',
                    'note'          => 'Base HTML Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'AMP Post',
                    'layout_type'   => LayoutType::Post,
                    'view'          => 'Blog::post.amp',
                    'note'          => 'AMP Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'Base Topic',
                    'layout_type'   => LayoutType::Topic,
                    'view'          => 'Blog::topic.base',
                    'note'          => 'Base HTML Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'AMP Page',
                    'layout_type'   => LayoutType::Topic,
                    'view'          => 'Blog::topic.amp',
                    'note'          => 'AMP Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'Base Series',
                    'layout_type'   => LayoutType::Series,
                    'view'          => 'Blog::series.base',
                    'note'          => 'Base HTML Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ],
                [
                    'name'          => 'AMP Series',
                    'layout_type'   => LayoutType::Series,
                    'view'          => 'Blog::series.amp',
                    'note'          => 'AMP Structure',
                    'created_at'    => '2021-04-09 10:00:00',
                    'updated_at'    => '2021-04-09 10:00:00',
                ]
            ] as $layout) {
                Layout::firstOrCreate($layout);
            }
        }
    }
}
