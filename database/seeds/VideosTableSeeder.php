<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('videos')->insert([
            ['title'      => 'Test video',
             'image'      => '1446029916-lighthouse.jpg',
             'url'      => 'https://www.youtube.com/',
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}
