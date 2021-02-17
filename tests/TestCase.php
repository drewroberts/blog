<?php

namespace DrewRoberts\Blog\Tests;

use DrewRoberts\Blog\BlogServiceProvider;
use DrewRoberts\Blog\Tests\Support\Models\Image;
use DrewRoberts\Blog\Tests\Support\Models\User;
use DrewRoberts\Blog\Tests\Support\Models\Video;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            BlogServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('tipoff.model_class.user', User::class);
        $app['config']->set('tipoff.model_class.image', Image::class);
        $app['config']->set('tipoff.model_class.video', Video::class);
    }
}
