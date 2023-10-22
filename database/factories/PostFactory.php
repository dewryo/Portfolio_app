<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            // その他のフィールド
        ];
    }

    /**
     * After creating the Post, attach some images and tags.
     *
     * @return void
     */
    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            // データベースから既存のTag IDをランダムに2つ取得
            $tagIds = Tag::inRandomOrder()->limit(2)->pluck('id');
    
            foreach ($tagIds as $tagId) {
                $type = ($tagId > 5) ? 'subject' : 'class';
                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tagId,
                    'type' => $type
                ]);
            }
        });
    }
}