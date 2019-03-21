<?php


use Illuminate\Database\Seeder;

class SlideTypesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('slide_types')->truncate();
        DB::table('slide_types')->insert([
            ['name' => 'intro', 'description' => 'Intropage'],
            ['name' => 'split', 'description' => 'Image/Text'],
            ['name' => 'picture', 'description' => 'Large image'],
            ['name' => 'images', 'description' => 'Images'],
//            ['name' => 'text', 'description' => 'Text'],
//            ['name' => 'procedure', 'description' => 'Procedure'],
//            ['name' => 'quote', 'description' => 'Quote'],
//            ['name' => 'pyramid', 'description' => 'Pyramid'],
//            ['name' => 'heading', 'description' => 'Heading'],
            ['name' => 'welcome', 'description' => 'Welcome'],
            ['name' => 'team', 'description' => 'Team'],
            ['name' => 'tombstone', 'description' => 'Tombstone'],
            ['name' => 'logo', 'description' => 'Logo'],
            ['name' => 'icons', 'description' => 'Icons'],
            ['name' => 'video', 'description' => 'Video'],
            ['name' => 'placeholder', 'description' => 'Placeholder'],
        ]);
    }
}