<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::create(
            [
                'name'      => 'Email Writing',
                'photo'     => '1679564745.png',
                'status'     => 'yes',
                'ordering'     => '1',
            ]
        );

        \App\Models\Category::create(
            [
                'name'      => 'Technology',
                'photo'     => '1679495142.png',
                'status'     => 'yes',
                'ordering'     => '2',
            ]
        );

        \App\Models\Category::create(
            [
                'name'      => 'Science',
                'photo'     => '1679495131.png',
                'status'     => 'yes',
                'ordering'     => '3',
            ]
        );
       
        \App\Models\Category::create(
            [
                'name'      => 'Fitness & Exercise',
                'photo'     => '1679495055.png',
                'status'     => 'yes',
                'ordering'     => '4',
            ]
        );

        \App\Models\Category::create(
            [
                'name'      => 'Investment & Trading',
                'photo'     => '1679495105.png',
                'status'     => 'yes',
                'ordering'     => '5',
            ]
        );

    }
}
