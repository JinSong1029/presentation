<?php

use Illuminate\Database\Seeder;

class DefaultSectionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('default_sections')->truncate();
        DB::table('default_sections')->insert([
            ['name' => 'Intro page', 'ordering' => '1', 'additional' => 0],
            ['name' => 'Case studies', 'ordering' => '2', 'additional' => 1],
            ['name' => 'Understanding your needs', 'ordering' => '3', 'additional' => 0],
            ['name' => 'CSR', 'ordering' => '4', 'additional' => 1],
            ['name' => 'How we can support you', 'ordering' => '5', 'additional' => 0],
            ['name' => 'International approach', 'ordering' => '6', 'additional' => 1],
            ['name' => 'Brexit support', 'ordering' => '7', 'additional' => 1],
            ['name' => 'Relevant experience', 'ordering' => '8', 'additional' => 0],
            ['name' => 'Our proposed team', 'ordering' => '9', 'additional' => 0],
            ['name' => 'Key issues', 'ordering' => '10', 'additional' => 0],
            ['name' => 'Added value', 'ordering' => '12', 'additional' => 0],
        ]);
    }
}