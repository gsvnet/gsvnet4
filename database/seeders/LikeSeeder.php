<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maxLikes = 20;

        $userIds = User::pluck('id')->all();
        $replyIds = Reply::pluck('id')->all();

        $faker = Factory::create(config('app.faker_locale'));
        $bar = $this->command->getOutput()->createProgressBar(count($replyIds));

        $likes = [];

        foreach ($replyIds as $i => $replyId) {
            $bar->advance();

            $numLikes = rand(0, $maxLikes);

            $likers = $faker->randomElements($userIds, $numLikes);
            foreach ($likers as $liker)
                $likes[] = $this->generateLike($replyId, $liker);

            DB::table('forum_replies')
                ->where('id', $replyId)
                ->update(['like_count' => $numLikes]);

            // We have to chunk our inserts, or MySQL complains
            if ($i % 100 == 0) {
                DB::table('likes')->insert($likes);
                $likes = [];
            }
        }

        DB::table('likes')->insert($likes);

        $bar->finish();
        echo "\n";
    }

    private function generateLike($replyId, $likerId) {
        return [
            'reply_id' => $replyId,
            'user_id' => $likerId
        ];
    }
}
