<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CheckListGroup>
 */
class CheckListGroupFactory extends Factory
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
            'description' => fake()->paragraph($nbSentences = 3),
            'created_at' => fake()->dateTimeBetween('-3 weeks')
        ];
    }

    /**
     * check list group
     *
     * @return void
     */
    public function lorem_ipsum()
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Lorem ipsum.',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam.'
        ]);
    }
}
