<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\User;
use Faker\Factory;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addRegions();
        $this->assignRegions();
    }

    private function addRegions() {
        $regions = [
            [
                'name' => 'Noord',
                'start_date' => '2018-05-29',
                'end_date' => NULL
            ], [
                'name' => 'Oost',
                'start_date' => '2018-05-29',
                'end_date' => NULL
            ], [
                'name' => 'Zuid',
                'start_date' => '2018-05-29',
                'end_date' => NULL
            ], [
                'name' => 'West',
                'start_date' => '2018-05-29',
                'end_date' => NULL
            ], [
                'name' => '1',
                'start_date' => '2011-08-01',
                'end_date' => '2018-05-29'
            ], [
                'name' => '2',
                'start_date' => '2011-08-01',
                'end_date' => '2018-05-29'
            ], [
                'name' => '3',
                'start_date' => '2011-08-01',
                'end_date' => '2018-05-29'
            ], [
                'name' => '4',
                'start_date' => '2011-08-01',
                'end_date' => '2018-05-29'
            ], [
                'name' => 'Rood',
                'start_date' => '2005-08-01',
                'end_date' => '2011-08-01'
            ], [
                'name' => 'Oranje',
                'start_date' => '2005-08-01',
                'end_date' => '2011-08-01'
            ], [
                'name' => 'Geel',
                'start_date' => '2005-08-01',
                'end_date' => '2011-08-01'
            ], [
                'name' => 'Groen',
                'start_date' => '2005-08-01',
                'end_date' => '2011-08-01'
            ], [
                'name' => 'Blauw',
                'start_date' => '2005-08-01',
                'end_date' => '2011-08-01'
            ], [
                'name' => 'Paars',
                'start_date' => '2005-08-01',
                'end_date' => '2011-08-01'
            ], [
                'name' => 'A',
                'start_date' => '2000-08-01',
                'end_date' => '2005-08-01'
            ], [
                'name' => 'B',
                'start_date' => '2000-08-01',
                'end_date' => '2005-08-01'
            ], [
                'name' => 'C',
                'start_date' => '2000-08-01',
                'end_date' => '2005-08-01'
            ], [
                'name' => 'D',
                'start_date' => '2000-08-01',
                'end_date' => '2005-08-01'
            ]
        ];

        DB::table('regions')->insert($regions);
    }

    private function assignRegions() {
        $faker = Factory::create(config('app.faker_locale'));

        $userIds = User::whereIn('type', [UserTypeEnum::MEMBER->value, UserTypeEnum::REUNIST->value])
            ->pluck('id')
            ->all();

        $activeRegionIds = Region::whereNull('end_date')->pluck('id')->all();
        $inactiveRegionIds = Region::whereNotNull('end_date')->pluck('id')->all();

        foreach ($userIds as $userId) {
            $user = User::find($userId);

            // Every member has an active region. Some have an inactive region as well.
            // A reunist can have an active region, both an active and inactive region,
            // or one or more inactive regions.
            $hasActiveRegion = true;
            $numInactiveRegions = rand(0, 1);
            if ($user->type == UserTypeEnum::REUNIST && $hasActiveRegion = $faker->boolean)
                $numInactiveRegions = 1;
            elseif ($user->type == UserTypeEnum::REUNIST)
                $numInactiveRegions = rand(1, 2);

            if ($hasActiveRegion) {
                $region = $faker->randomElement($activeRegionIds);

                $user->profile->regions()->attach($region);
            }

            $regionIds = $faker->randomElements($inactiveRegionIds, $numInactiveRegions);
            foreach ($regionIds as $regionId)
                $user->profile->regions()->attach($regionId);
        }
    }
}
