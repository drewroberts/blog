<?php

namespace DrewRoberts\Blog;

use DrewRoberts\Blog\Commands\BlogCommand;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/blog.php' => config_path('blog.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/blog'),
            ], 'views');

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
