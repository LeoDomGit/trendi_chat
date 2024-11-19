<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \App\Models\Language::create(
            [
                'name'      => 'English',
                'code'     => 'en',
                'photo'     => 'ic_uk.png',
                'is_rtl'     => 'no',
                'status'     => 'yes',
            ]
        );

    }
}
