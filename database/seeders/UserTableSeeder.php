<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(
            [
                'name'      => 'admin',
                'email'     => 'admin@quickl.com',
                'password'  => Hash::make('12345678'),
            ]
        );

        \App\Models\User::create(
            [
                'name'      => 'Super User',
                'email'     => 'admin@demo.com',
                'password'  => Hash::make('12345678'),
            ]
        );
    }
}
