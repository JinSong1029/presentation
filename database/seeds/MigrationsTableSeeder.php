<?php

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->truncate();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'migration' => '2014_10_12_000000_create_users_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'migration' => '2014_10_12_100000_create_password_resets_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'migration' => '2015_09_07_180037_entrust_setup_tables',
                'batch' => 1,
            ),
            3 => 
            array (
                'migration' => '2015_09_17_124334_crete_default_sections_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'migration' => '2015_09_18_123022_create_presentations_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'migration' => '2015_09_18_125807_create_sections_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'migration' => '2015_09_22_114950_create_slides_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'migration' => '2015_09_22_115352_create_images_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'migration' => '2015_09_22_115400_create_videos_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'migration' => '2015_09_22_115410_create_texts_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'migration' => '2015_09_22_115753_create_tombstones_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'migration' => '2015_09_22_124258_create-slide_types_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'migration' => '2015_09_30_070859_create_slideables_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'migration' => '2015_12_09_084139_create_procedures_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'migration' => '2015_12_09_103516_create_quotes_table',
                'batch' => 1,
            ),
            15 => 
            array (
                'migration' => '2016_01_18_113415_create_pyramyd_groups_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'migration' => '2016_08_29_113116_create_splits_table',
                'batch' => 1,
            ),
        ));
        
        
    }
}
