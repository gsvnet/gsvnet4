<?php

namespace Database\Seeders;

use App\Models\Senate;
use App\Models\User;
use GSVnet\Senates\SenateFunction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SenateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Senate::factory()
            ->hasAttached(User::factory(), ['function' => SenateFunction::PRAESES->value], 'members')
            ->hasAttached(User::factory(), ['function' => SenateFunction::ABACTIS->value], 'members')
            ->hasAttached(User::factory(), ['function' => SenateFunction::FISCUS->value], 'members')
            ->hasAttached(User::factory(), ['function' => SenateFunction::ASSESSOR_PRIMUS->value], 'members')
            ->hasAttached(User::factory(), ['function' => SenateFunction::ASSESSOR_SECUNDUS->value], 'members')
            ->count(60)
            ->create();
    }
}
