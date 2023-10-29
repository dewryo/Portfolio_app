<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'post_id' => Post::factory(),
            'file_path' => $this->faker->imageUrl(),
            'file_name' => $this->faker->word,
            // その他のフィールド
        ];
    }
}

