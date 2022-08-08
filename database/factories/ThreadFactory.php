<?php

namespace Database\Factories;

use Carbon\Carbon;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subject = $this->faker->text(20);
        $now = Carbon::now();

        // Set author_id, most_recent_reply_id, reply_count externally

        return [
            'subject' => $subject,
            'slug' => Str::slug($subject. '-' . $this->faker->asciify('****')),
            'visibility' => $this->faker->randomElement(VisibilityLevel::cases()),
            'deleted_at' => $this->faker->boolean(10) ? $now->toDateTimeString() : null
        ];
    }
}
