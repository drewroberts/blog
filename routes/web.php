<?php

use DrewRoberts\Blog\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('tipoff.web.middleware_group'))
    ->prefix(config('tipoff.web.uri_prefix'))
    ->group(function () {

        Route::get('/blog/{post}', PostController::class)->name('post');
    });
