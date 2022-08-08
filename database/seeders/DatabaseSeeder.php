<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TagSeeder::class,
            LabelSeeder::class,
            CommitteeSeeder::class,
            EventSeeder::class,
            YearGroupSeeder::class,
            UserSeeder::class,
            RegionSeeder::class,
            UserCommitteeSeeder::class,
            SenateSeeder::class,
            ThreadSeeder::class,
            LikeSeeder::class
        ]);
    }
}
