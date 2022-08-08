<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numThreads = 50;
        $numReplies = 50; // TODO: Find an elegant way to make the number of replies variable per thread

        $userIds = User::pluck('id')->all();
        $faker = Factory::create(config('app.faker_locale'));

        Thread::factory()
            ->hasReplies(
                $numReplies,
                fn ($attr, $thread) => ['author_id' => $faker->randomElement($userIds)]
            )
            ->count($numThreads)
            ->state(new Sequence(
                fn ($sequence) => [
                    'author_id' => $faker->randomElement($userIds),
                    'most_recent_reply_id' => $sequence->index * $numReplies + 1,
                    'reply_count' => $numReplies
                ]
            ))
            ->create();
    }
}
