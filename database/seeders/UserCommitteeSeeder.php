<?php

namespace Database\Seeders;

use App\Models\Committee;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use GSVnet\Users\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::where('type', UserType::MEMBER->value)->pluck('id');
        $committeeIds = Committee::pluck('id')->all(); // all() converts from Collection to array
        $faker = Factory::create(config('app.faker_locale'));

        $memberships = [];

        foreach($userIds as $userId)
        {
            // 4 out of 10 are not in a committee
            if($faker->boolean(40))
                continue;

            $total = $faker->numberBetween(1, 3);
            $randCommIds = $faker->randomElements($committeeIds, $total);

            foreach($randCommIds as $committeeId)
            {
                $startDate = Carbon::create($faker->dateTimeBetween('-3 years', '-1 month'));

                $memberships[] = [
                    'committee_id' => $committeeId,
                    'user_id' => $userId,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $startDate->addYear()->format('Y-m-d'),
                ];
            }
        }

        DB::table('committee_user')->insert($memberships);
    }
}
