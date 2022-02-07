<?php

namespace Coderflex\Laravisit\Database\Factories;

use Coderflex\Laravisit\Tests\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }

}