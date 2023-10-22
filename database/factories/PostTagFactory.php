<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagFactory extends Factory
{
    protected $model = PostTag::class;

    public function definition()
    {
        return [
            'post_id' => \App\Models\Post::factory(),
            'tag_id' => $this->faker->randomElement(range(1, 17)),
        ];
    }
}

