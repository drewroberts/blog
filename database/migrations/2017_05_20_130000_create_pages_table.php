<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('title')->unique();
            $table->text('content')->nullable(); // Will be written in Markdown.
            $table->string('description')->nullable(); // Primary description used for SEO.
            $table->string('ogdescription')->nullable(); // Open Graph Description used for social shares. Will default to description if NULL.
            $table->unsignedInteger('pageviews')->index(); // Total current pageviews for page. Will be synced from Google Analytics API.

            $table->foreignIdFor(app('page'), 'parent_id')->nullable(); // Parent Page
            $table->foreignIdFor(app('image'))->nullable(); // Cover image for page
            $table->foreignIdFor(app('image'), 'ogimage_id')->nullable(); // External open graph image id. Featured image for social sharing. Will default to image_id unless this is used. Allows override for play button or words on image.
            $table->foreignIdFor(app('video'))->nullable(); // If page has a featured video.

            $table->foreignIdFor(app('user'), 'author_id'); // Author of the page
            $table->foreignIdFor(app('user'), 'creator_id');
            $table->foreignIdFor(app('user'), 'updater_id');

            $table->dateTime('published_at'); // Allows pages to be published at a later date.
            $table->softDeletes();
            $table->timestamps();
        });
    }
}
