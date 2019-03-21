<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(DefaultSectionsTableSeeder::class);
        $this->call(SlideTypesTableSeeder::class);
        $this->call(PresentationsTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(SlidesTableSeeder::class);
        $this->call(TombstonesTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(QuotesTableSeeder::class);
        $this->call(VideosTableSeeder::class);
        $this->call(TextsTableSeeder::class);
        $this->call(ProceduresTableSeeder::class);
        $this->call(PyramidGroupsTableSeeder::class);
        $this->call(IconsTableSeeder::class);
        $this->call(GallarysTableSeeder::class);
        $this->call(TeamsTableSeeder::class);

        Model::reguard();
    }
}
