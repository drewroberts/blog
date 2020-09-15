<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('title')->unique();
            $table->string('note')->nullable(); // Just for internal reference purposes only, not displayed on website.
            $table->text('content')->nullable(); // Will be written in Markdown.
            $table->string('description')->nullable(); // Primary description used for SEO.
            $table->string('ogdescription')->nullable(); // Open Graph Description used for social shares. Will default to description if NULL.
            $table->unsignedInteger('pageviews')->nullable(); // Total current pageviews for topic page. Will be synced from Google Analytics API.

            $table->foreignId('image_id')->nullable()->references('id')->on('images'); // Cover image for topic
            $table->foreignId('ogimage_id')->nullable()->references('id')->on('images'); // External open graph image id. Featured image for social sharing. Will default to image_id unless this is used. Allows override for play button or words on image.
            $table->foreignId('video_id')->nullable()->references('id')->on('videos'); // If topic has a featured video.

            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('updater_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
}
