<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'riky',
            'email' => 'riky@mail.com',
            'password' => bcrypt('rahasia'),
            'level' => 'admin',
        ]);
    }
}
