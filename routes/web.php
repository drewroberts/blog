<?php

use Illuminate\Support\Facades\Route;
use DrewRoberts\Blog\Http\Controllers\PageController;
use DrewRoberts\Blog\Http\Controllers\TopicController;
use DrewRoberts\Blog\Http\Controllers\SeriesController;
use DrewRoberts\Blog\Http\Controllers\PostController;


Route::middleware(config('tipoff.web.middleware_group'))
    ->prefix(config('tipoff.web.uri_prefix'))
    ->group(function () {

        Route::get('/blog/{page}/{child_page}/{grand_child_page}', PageController::class)
            ->name('page');

        Route::get('/blog/{topic}', TopicController::class)->name('topic');
		Route::get('/blog/{topic}/{series}', SeriesController::class)->name('series');
		Route::get('/blog/{topic}/{series}/{post}', PostController::class)->name('post');

    });