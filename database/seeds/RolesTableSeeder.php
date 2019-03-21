<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'admin','display_name'=>'Administrator','description'=>'Has access in every part of application '],
            ['name' => 'staff','display_name'=>'Staff','description'=>'Can create clients and presentations'],
            ['name' => 'client','display_name'=>'Client','description'=>'Can watch presentations '],
        ]);
    }
}