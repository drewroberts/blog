<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->index();
            $table->string('title')->unique();
            $table->string('description')->nullable();
            $table->string('note')->nullable(); // Just for internal reference purposes only, not displayed on website.
            $table->foreignId('topic_id')->references('id')->on('topics'); // Group series into larger topics

            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('updater_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
}
