<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            ['name'      => null,
             'image'      => '1444650349-penguins.jpg',
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('images')->insert([
            ['name'      => 'Logo',
             'image'      => '1445971805-hydrangeas.jpg',
             'desc'       => 'test logo description',
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('images')->insert([
            ['name'      => 'Logo 1',
             'image'      => '1446028520-jellyfish.jpg',
             'desc'       => 'test logo description 22222',
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}
