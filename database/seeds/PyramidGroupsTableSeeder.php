<?php
use Illuminate\Database\Seeder;

class PyramidGroupsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pyramid_groups')->insert([
            [
                'title' => 'PULL OUT 1 TITLE',
                'inside_triangle' => 0,
                'content' => 'Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here.',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        DB::table('pyramid_groups')->insert([
            [
                'title' => 'PULL OUT 1 TITLE',
                'inside_triangle' => 0,
                'content' => 'Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here.',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        DB::table('pyramid_groups')->insert([
            [
                'title' => 'PULL OUT 1 TITLE',
                'inside_triangle' => 0,
                'content' => 'Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here.',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        DB::table('pyramid_groups')->insert([
            [
                'title' => 'PULL OUT 1 TITLE',
                'inside_triangle' => 0,
                'content' => 'Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here. Your explanatory text would go here.',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

    }
}