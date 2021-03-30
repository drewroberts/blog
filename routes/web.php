<?php

use Illuminate\Support\Facades\Route;
use DrewRoberts\Blog\Http\Controllers\PageController;
use DrewRoberts\Blog\Http\Controllers\TopicController;
use DrewRoberts\Blog\Http\Middleware\ResolvePage;


Route::middleware(config('tipoff.web.middleware_group'))
    ->prefix(config('tipoff.web.uri_prefix'))
    ->group(function () {

        Route::get('{page}/{child-page}/{grandchild-page}', PageController::class)
            ->name('page');

            Route::get('{topic}/{series}/{post}', TopicController::class)
            ->name('blog');

    });