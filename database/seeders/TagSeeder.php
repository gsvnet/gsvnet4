<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [];
        $commonTags = [
            'GSV' => 'GSV-specifieke onderwerpen',
            'Nieuws' => 'alle typen nieuwsberichten',
            'Discussie' => 'voor onderwerpen die een discussie te weeg brengen',
            'Senaat' => 'huidige en oude senaten, vragen aan de senaat',
            'Amicaal' => 'VGS-Nederland, broeder- en zusterverenigingen',
            'Oud-leden' => 'alumni van de GSV',

            'Regio' => 'onderwerpen met betrekking tot één der regionen',
            'Jaarverband' => 'onderwerpen met betrekking tot een jaarverband',
            'Commissie' => 'vragen over of mededelingen van commissies',

            'Politiek' => 'onderwerpen met betrekking tot politiek',
            'Maatschappij' => 'voor maatschappelijke stages, et cetera',
            'Geloof' => 'onderwerpen met betrekking tot geloof',
            'Wetenschap' => 'onderwerpen met betrekking tot wetenschap',
            'Vraag' => 'op zoek naar een kamer, gereedschap, een boek, of iets anders',
            'Aanbod' => 'kamer aangeboden of iets anders',

            'Website' => 'vragen en opmerking over de site',
        ];

        foreach ($commonTags as $name => $description) {
            $tags[] = [
                'name' => $name,
                'description' => $description,
                'slug' => Str::slug($name)
            ];
        }

        DB::table('tags')->insert($tags);
    }
}
