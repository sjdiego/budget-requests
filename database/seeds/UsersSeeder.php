<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'email' => 'user@example.test',
            'phone' => '971 75 00 00',
            'address' => 'Fake St. 123'
        ]);
    }
}
