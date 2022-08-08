<?php

namespace Database\Seeders;

use App\Models\Committee;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use GSVnet\Users\UserType;
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

        echo "Seeding admin user...\n";
        // Admin user
        $loran = User::factory()
            ->hasProfile(1, ['year_group_id' => $faker->randomElement($yearGroupIds)])
            ->create([
                'firstname' => 'Loran',
                'middlename' => '',
                'lastname' => 'Knol',
                'username' => 'Valkje',
                'email' => 'loran.knol@gmail.com',
                'type' => UserType::MEMBER,
                'approved' => true
            ]);
        $webcie = Committee::where('unique_name', 'webcie')->first();
        $loran->committees()->save($webcie, ['start_date' => Carbon::now()]);

        // Fake users with profile
        echo "Seeding users with profile...\n";
        User::factory()
            ->profileType()
            ->hasProfile(1, function (array $attributes, User $user) use ($faker, $yearGroupIds) {
                return ['year_group_id' => $faker->randomElement($yearGroupIds)];
            })
            ->count($this->numUsersWithProfiles)
            ->create();

        // Fake users without profile
        echo "Seeding users without profile...\n";
        User::factory()
            ->noProfileType()
            ->count($this->totalUsers - $this->numUsersWithProfiles)
            ->create();
    }
}
