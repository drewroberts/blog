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

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('blog')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration([
                '2017_05_20_100000_create_topics_table',
                '2017_05_20_110000_create_series_table',
                '2017_05_20_120000_create_posts_table',
                '2017_05_20_130000_create_pages_table'
            ])
            ->hasCommand(BlogCommand::class);
    }

    /**
     * Using packageBooted lifecycle hooks to override the migration file name.
     * We want to keep the old filename for now.
     */
    public function packageBooted()
    {
        foreach ($this->package->migrationFileNames as $migrationFileName) {
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    $this->package->basePath("/../database/migrations/{$migrationFileName}.php.stub") => database_path('migrations/' . Str::finish($migrationFileName, '.php')),
                ], "{$this->package->name}-migrations");
            }
        }
    }
}
