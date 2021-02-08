<?php

namespace DrewRoberts\Blog\Database\Factories;

use App\Models\User;
use DrewRoberts\Blog\Models\Page;
use DrewRoberts\Media\Models\Image;
use DrewRoberts\Media\Models\Video;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

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
            'image_id'         => randomOrCreate(app('image')),
            'ogimage_id'       => randomOrCreate(app('image')),
            'video_id'         => randomOrCreate(app('video')),
            'author_id'        => randomOrCreate(app('user')),
            'creator_id'       => randomOrCreate(app('user')),
            'updater_id'       => randomOrCreate(app('user')),
            'published_at'     => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        ];
    }
}
