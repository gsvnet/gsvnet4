<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reply>
 */
class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // thread_id and author_id are set externally
        $now = Carbon::now();

        return [
            'body' => $this->faker->paragraphs(rand(1, 5), true),
            'like_count' => 0, // We don't seed likes for now
            'deleted_at' => $this->faker->boolean(10) ? $now->toDateTimeString() : null
        ];
    }
}
