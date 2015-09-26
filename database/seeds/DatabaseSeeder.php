<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use  ImagesManager\User;
use  ImagesManager\Album;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // There is a foreign key in the Albums table to the Users table 
        // so we need to do this:
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Model::unguard();

        User::truncate();
        Album::truncate();

        $this->call(UserTableSeeder::class);
        $this->call(AlbumTableSeeder::class);

        Model::reguard();
    }
}
