<?php

namespace DrewRoberts\Blog;

use Illuminate\Support\ServiceProvider;
use DrewRoberts\Blog\Commands\BlogCommand;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blog.php' => config_path('blog.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/blog'),
            ], 'views');

            if (! class_exists('CreatePackageTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_blog_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_blog_table.php'),
                ], 'migrations');
            }

            $this->commands([
                BlogCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blog');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blog.php', 'blog');
    }
}
