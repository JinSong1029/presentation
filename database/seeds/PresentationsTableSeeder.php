<?php

use Illuminate\Database\Seeder;

class PresentationsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('presentations')->insert([
            ['title' => 'presentation',
                'client'=>'Client',
                'slug'=>'presentation-1',
                'key'=>'kdfQxE2xedUM2Dh3',
                'hidden'=>0,
                'archived'=>0,
                'author_id'=>1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        factory(App\Models\Presentation::class)->create(['title'=>'Test presentation','client'=>'test','key'=>'kdfQxE2xedUM2Dh4']);
    }
}