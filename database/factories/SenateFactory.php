<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Senate>
 */
class SenateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_date = Carbon::create($this->faker->dateTimeBetween('-60 years', 'now'));

        return [
            'name' => $this->faker->lastName,
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $start_date->addYear(),
            'body' => $this->faker->text
        ];
    }
}
