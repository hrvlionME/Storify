<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['short', 'long']);
        if($type == 'long'){
            $body = fake()->paragraph();
        } else {
            $body = fake()->text(200);
        }
        return [
            //
            'user_id' => fake()->numberBetween(1, 2),
            'title' => fake()->unique()->paragraph(),
            'body' => $body,
            'type' => $type,
            'status' => fake()->boolean()
        ];
    }
}
