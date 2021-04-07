<?php

declare(strict_types=1);

namespace DrewRoberts\Blog\Http\Middleware;


use DrewRoberts\Blog\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Middleware\ServeNova;

class ServeBlog extends ServeNova
{
    public static function blogRoutes(): \Closure
    {
        return function () {
            Route::middleware(config('tipoff.web.middleware_group'))
                ->prefix(config('tipoff.web.uri_prefix'))
                ->group(function () {
                    Route::get('/{slug1}/{slug2?}/{slug3?}', BlogController::class)->name('blog');
                });
        };
    }

    public function handle($request, $next)
    {
        // If NOT a nova request, register blog routes now.  Registration of routes when it
        // is a Nova request will be triggered by Nova::booted(...)
        if (!$this->isNovaRequest($request)) {
            (self::blogRoutes())();
        }

        return $next($request);
    }
}
