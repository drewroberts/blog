<?php

namespace DrewRoberts\Blog\Database\Factories;

use App\Models\User;
use DrewRoberts\Blog\Models\Topic;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition()
    {
        $word = $this->faker->unique()->word;

        return [
            'slug'              => Str::slug($word),
            'title'             => $word,
            'description'       => $this->faker->sentences(1, true),
            'note'              => $this->faker->sentences(1, true),
            'pageviews'         => $this->faker->numberBetween(1, 400),
            'creator_id'        => randomOrCreate(User::class),
            'updater_id'        => randomOrCreate(User::class),
        ];
    }
}
