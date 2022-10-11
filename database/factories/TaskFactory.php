<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence($nbWords = 1),
            'description' => fake()->paragraph($nbSentences = 2),
            'created_at' => fake()->dateTimeBetween('-1 week')
        ];
    }

    /**
     * page
     *
     * @return void
     */
    public function lorem_ipsum()
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Task ipsum.',
            'description' => 'Task Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia, neque.'
        ]);
    }
}
