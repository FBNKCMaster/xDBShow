<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    // https://laravel.com/docs/9.x/database-testing#factory-and-model-discovery-conventions
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Tests\Models\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'body' => $this->faker->text(),
            'views' => mt_rand(0, 1000),
            'published_at' => now(),
            'status' => [true, false][mt_rand(0, 1)],
        ];
    }

}
