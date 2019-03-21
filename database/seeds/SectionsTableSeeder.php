<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('sections')->insert([

            ['name' => 'The team / contacts', 'ordering' => '2', 'presentation_id' => 1],
            ['name' => 'Core values', 'ordering' => '3', 'presentation_id' => 1],
            ['name' => 'Awards / accreditations / quotes', 'ordering' => '4', 'presentation_id' => 1],
            ['name' => 'About client  / Client requirements', 'ordering' => '5', 'presentation_id' => 1],
            ['name' => 'Experience  / Credentials', 'ordering' => '6', 'presentation_id' => 1],
            ['name' => 'Logos', 'ordering' => '7', 'presentation_id' => 1],
            ['name' => 'Fees', 'ordering' => '8', 'presentation_id' => 1],
            ['name' => 'Summary', 'ordering' => '9', 'presentation_id' => 1],
            ['name' => 'Case studies', 'ordering' => '10', 'presentation_id' => 1],
            ['name' => 'Key issues  / challenges', 'ordering' => '11', 'presentation_id' => 1],
            ['name' => 'Deliverables  / How we can help', 'ordering' => '12', 'presentation_id' => 1],
            ['name' => 'USPs', 'ordering' => '13', 'presentation_id' => 1],
            ['name' => 'Technical process  / timetable', 'ordering' => '14', 'presentation_id' => 1],
            ['name' => 'Word clouds', 'ordering' => '15', 'presentation_id' => 1],
            ['name' => 'Intro page', 'ordering' => '1', 'presentation_id' => 1],
        ]);
        DB::table('sections')->insert([

            ['name' => 'The team / contacts', 'ordering' => '2', 'presentation_id' => 2],
            ['name' => 'Core values', 'ordering' => '3', 'presentation_id' => 2],
            ['name' => 'Awards / accreditations / quotes', 'ordering' => '4', 'presentation_id' => 2],
            ['name' => 'About client  / Client requirements', 'ordering' => '5', 'presentation_id' => 2],
            ['name' => 'Experience  / Credentials', 'ordering' => '6', 'presentation_id' => 2],
            ['name' => 'Logos', 'ordering' => '7', 'presentation_id' => 2],
            ['name' => 'Fees', 'ordering' => '8', 'presentation_id' => 2],
            ['name' => 'Summary', 'ordering' => '9', 'presentation_id' => 2],
            ['name' => 'Case studies', 'ordering' => '10', 'presentation_id' => 2],
            ['name' => 'Key issues  / challenges', 'ordering' => '11', 'presentation_id' => 2],
            ['name' => 'Deliverables  / How we can help', 'ordering' => '12', 'presentation_id' => 2],
            ['name' => 'USPs', 'ordering' => '13', 'presentation_id' => 2],
            ['name' => 'Technical process  / timetable', 'ordering' => '14', 'presentation_id' => 2],
            ['name' => 'Word clouds', 'ordering' => '15', 'presentation_id' => 2],
            ['name' => 'Intro page', 'ordering' => '1', 'presentation_id' => 2],
        ]);
    }
}