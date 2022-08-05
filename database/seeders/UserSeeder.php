<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    private int $totalUsers = 2000;
    private int $numUsersWithProfiles = 1000;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $yearGroupIds = DB::table('year_groups')->pluck('id');
        $faker = Factory::create(config('app.faker_locale'));

        User::factory()
            ->profileType()
            ->hasProfile(1, function (array $attributes, User $user) use ($faker, $yearGroupIds) {
                return ['year_group_id' => $faker->randomElement($yearGroupIds)];
            })
            ->count($this->numUsersWithProfiles)
            ->create();

        User::factory()
            ->noProfileType()
            ->count($this->totalUsers - $this->numUsersWithProfiles)
            ->create();
    }
}
