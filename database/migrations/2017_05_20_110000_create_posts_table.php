<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('title')->unique();
            $table->text('content')->nullable(); // Will be written in Markdown.
            $table->string('description')->nullable(); // Primary description used for SEO.
            $table->string('ogdescription')->nullable(); // Open Graph Description used for social shares. Will default to description if NULL.
            $table->unsignedInteger('pageviews')->index(); // Total current pageviews for post. Will be synced from Google Analytics API.

            $table->foreignId('topic_id')->references('id')->on('topics'); // Group blog posts into topics
            $table->foreignId('image_id')->nullable()->references('id')->on('images'); // Cover image for post
            $table->foreignId('ogimage_id')->nullable()->references('id')->on('images'); // External open graph image id. Featured image for social sharing. Will default to image_id unless this is used. Allows override for play button or words on image.
            $table->foreignId('video_id')->nullable()->references('id')->on('videos'); // If blog post has a featured video.
            
            $table->foreignId('author_id')->references('id')->on('users'); // Author of the post.
            $table->foreignId('updater_id')->references('id')->on('users');

            $table->dateTime('published_at'); // Allows blog posts to be published at a later date.
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
