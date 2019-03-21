<?php

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('slides')->insert([
            ['name'       => 'new slide',
             'type'       => 'tombstone',
             'section_id' => 1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('slideables')->insert([
            [
                'slide_id'       => 1,
                'slideable_id'   => 1,
                'slideable_type' => 'App\Models\SlideTypes\Tombstone',
            ],
        ]);
        //Second Presentation tombstone slide
        DB::table('slides')->insert([
            ['name'       => 'Test slide tombstone',
             'type'       => 'tombstone',
             'section_id' => 16,
             'ordering'   => 1,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 2,
            'slideable_id'   => 2,
            'slideable_type' => 'App\Models\SlideTypes\Tombstone',
        ],
        ]);

        DB::table('slideables')->insert([[
            'slide_id'       => 2,
            'slideable_id'   => 3,
            'slideable_type' => 'App\Models\SlideTypes\Tombstone',
        ],
        ]);

        DB::table('slideables')->insert([[
            'slide_id'       => 2,
            'slideable_id'   => 4,
            'slideable_type' => 'App\Models\SlideTypes\Tombstone',
        ],
        ]);
        //////
        //Second Presentation image slide
        DB::table('slides')->insert([
            ['name'       => 'Test slide image',
             'type'       => 'picture',
             'section_id' => 16,
             'ordering'   => 2,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 3,
            'slideable_id'   => 1,
            'slideable_type' => 'App\Models\SlideTypes\Image',
        ],
        ]);
        //////
        //Second Presentation logos slide
        DB::table('slides')->insert([
            ['name'       => 'Test slide logos',
             'type'       => 'logo',
             'section_id' => 16,
             'ordering'   => 3,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 4,
            'slideable_id'   => 2,
            'position'       => 1,
            'slideable_type' => 'App\Models\SlideTypes\Image',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 4,
            'slideable_id'   => 3,
            'position'       => 2,
            'slideable_type' => 'App\Models\SlideTypes\Image',
        ],
        ]);
        //////
        //Second Presentation video slide
        DB::table('slides')->insert([
            ['name'       => 'Test slide video',
             'type'       => 'video',
             'section_id' => 16,
             'ordering'   => 4,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 5,
            'slideable_id'   => 1,
            'slideable_type' => 'App\Models\SlideTypes\Video',
        ],
        ]);
        //////
        //Second Presentation text slide
        DB::table('slides')->insert([
            ['name'       => 'Test slide text',
             'type'       => 'text',
             'section_id' => 16,
             'ordering'   => 5,
             'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
             'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 6,
            'slideable_id'   => 1,
            'slideable_type' => 'App\Models\SlideTypes\Text',
        ],
        ]);

        //Second Presentation procedure slide
        DB::table('slides')->insert([
            ['name'       => 'Procedure testsss',
                'type'       => 'procedure',
                'section_id' => 16,
                'ordering'   => 7,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        //Second Presentation text slide
        DB::table('slides')->insert([
            ['name'       => 'Quotess test',
                'type'       => 'quote',
                'section_id' => 16,
                'ordering'   => 8,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);



        DB::table('slideables')->insert([[
            'slide_id'       => 7,
            'slideable_id'   => 1,
            'slideable_type' => 'App\Models\SlideTypes\Procedure',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 7,
            'slideable_id'   => 2,
            'slideable_type' => 'App\Models\SlideTypes\Procedure',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 7,
            'slideable_id'   => 3,
            'slideable_type' => 'App\Models\SlideTypes\Procedure',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 7,
            'slideable_id'   => 4,
            'slideable_type' => 'App\Models\SlideTypes\Procedure',
        ],
        ]);



        //Second Presentation text slide
        DB::table('slides')->insert([
            ['name'       => 'Pyramid test',
                'type'       => 'pyramid',
                'section_id' => 16,
                'ordering'   => 9,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ]);

        DB::table('slideables')->insert([[
            'slide_id'       => 9,
            'slideable_id'   => 1,
            'position'       => 1,
            'slideable_type' => 'App\Models\SlideTypes\PyramidGroup',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 9,
            'slideable_id'   => 2,
            'position'       => 2,
            'slideable_type' => 'App\Models\SlideTypes\PyramidGroup',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 9,
            'slideable_id'   => 3,
            'position'       => 3,
            'slideable_type' => 'App\Models\SlideTypes\PyramidGroup',
        ],
        ]);
        DB::table('slideables')->insert([[
            'slide_id'       => 9,
            'slideable_id'   => 4,
            'position'       => 4,
            'slideable_type' => 'App\Models\SlideTypes\PyramidGroup',
        ],
        ]);

   }
}