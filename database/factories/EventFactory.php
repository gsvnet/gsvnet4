<?php

namespace Database\Factories;

use Carbon\Carbon;
use GSVnet\Events\EventType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    private array $activities = ['Schaatsen', 'Bijbelkring', 'Voetballen', 'Lezing', 'Soos', 'Je moeder', 'Volleyballen', 'Huishoudelijke vergadering', 'Regiokamp'];
    private array $locations = ['Soos', 'De Loods', '', '', '', 'Vinkhuizen', 'Oosterkerk'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->randomElement($this->activities);
        $startDate = Carbon::create($this->faker->dateTimeBetween('-1 year', '+1 month'));

        return [
            'title' => $title,
            'description' => $this->faker->text(100),
            'meta_description' => $this->faker->text(30),
            'slug' => Str::slug($title) . '-' . $this->faker->asciify('******'),
            'whole_day' => $this->faker->boolean(),
            'type' => $this->faker->randomElement(EventType::cases()),
            'public' => $this->faker->boolean(),
            'start_date' => $startDate->format('Y-m-d'),
            'start_time' => $startDate->format('h:i'),
            'end_date' => $startDate->addDays(rand(0, 2))->format('Y-m-d'),
            'published' => $this->faker->boolean(70)
        ];
    }
}
