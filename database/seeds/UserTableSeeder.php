<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


use  ImagesManager\User;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 50; $i++) { 
            User::create
            ([
                'name' => "User $i",
                'email' => "User$i@users.com",
                'password' => bcrypt('pass'),
                'question' => "question",
                'answer' => bcrypt('ans'),
            ]);
        }
    }
}
