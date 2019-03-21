<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder

{
    public function run()
    {
       DB::table('users')->insert([
            'name' => 'Global admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123123'),
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        factory(App\Models\User::class,4)->create()->each(function ($u) {
            $u->attachRole(3);
        });
        factory(App\Models\User::class,2)->create()->each(function ($u) {
            $u->attachRole(2);
        });
    }
}