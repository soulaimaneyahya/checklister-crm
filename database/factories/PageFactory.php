<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence($nbWords = 1),
            'content' => fake()->paragraph($nbSentences = 3)
        ];
    }

    /**
     * welcome page
     *
     * @return void
     */
    public function welcome()
    {
        return $this->state(fn (array $attributes) => [
            'title'      => 'Welcome'
        ]);
    }

    /**
     * get consultation page
     *
     * @return void
     */
    public function consultation()
    {
        return $this->state(fn (array $attributes) => [
            'title'      => 'Get Consultation'
        ]);
    }

    /**
     * page
     *
     * @return void
     */
    public function lorem_ipsum()
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'Lorem ipsum.',
            'content' => 'Lorem ipsum dolor sit amet.'
        ]);
    }
}
