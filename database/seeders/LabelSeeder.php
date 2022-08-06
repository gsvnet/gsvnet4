<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = [
            [
                'name' => 'Commissies'
            ],
            [
                'name' => 'Notulen'
            ],
            [
                'name' => 'Senaat'
            ]
        ];

        DB::table('labels')->insert($labels);
    }
}
