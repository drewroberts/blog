<?php

namespace DrewRoberts\Blog\Database\Factories;

use App\Models\User;
use DrewRoberts\Blog\Models\Post;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Media\Models\Image;
use DrewRoberts\Media\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $word1 = $this->faker->name;
        $word2 = $this->faker->word;

        return [
            'slug'             => Str::slug($word1 . $word2),
            'title'            => $word1 . $word2,
            'content'          => $this->faker->sentences(3, true),
            'description'      => $this->faker->sentences(1, true),
            'pageviews'        => $this->faker->numberBetween(1, 400),
            'series_id'        => randomOrCreate(Series::class),
            'image_id'         => randomOrCreate(Image::class),
            'ogimage_id'       => randomOrCreate(Image::class),
            'video_id'         => randomOrCreate(Video::class),
            'author_id'        => randomOrCreate(User::class),
            'creator_id'       => randomOrCreate(User::class),
            'updater_id'       => randomOrCreate(User::class),
            'published_at'     => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        ];
    }
}
