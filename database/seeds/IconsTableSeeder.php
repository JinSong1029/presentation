<?php

use Illuminate\Database\Seeder;

class IconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('icons')->insert([
            ['name'      => null,
             'image'      => '1444650349-penguins.jpg',
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}
