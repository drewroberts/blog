<?php

namespace DrewRoberts\Blog\Database\Factories;

use App\Models\User;
use DrewRoberts\Blog\Models\Series;
use DrewRoberts\Blog\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public function definition()
    {
        $word = $this->faker->unique()->word;

        return [
            'slug'              => Str::slug($word),
            'title'             => $word,
            'note'              => $this->faker->sentences(1, true),
            'description'       => $this->faker->sentences(1, true),
            'pageviews'         => $this->faker->numberBetween(0, 5000),
            'topic_id'          => randomOrCreateRelation(Topic::class),
            'creator_id'        => randomOrCreateRelation(User::class),
            'updater_id'        => randomOrCreateRelation(User::class),
        ];
    }
}
