<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'comment' => 'Static text!'
        ];
    }
}
