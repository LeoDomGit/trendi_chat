<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SuggestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Suggestion::create(
            [
                'name'      => "I want you to write an email to ~#reject supplier's offer~ because of the ~#high price.",
                'category_id'     => '1',
                'status'     => 'yes',
            ]
        );

        \App\Models\Suggestion::create(
            [
                'name'      => "What are the latest technology trends?",
                'category_id'     => '2',
                'status'     => 'yes',
            ]
        );

        \App\Models\Suggestion::create(
            [
                'name'      => "What are the different branches of science?",
                'category_id'     => '3',
                'status'     => 'yes',
            ]
        );

        \App\Models\Suggestion::create(
            [
                'name'      => "How to loss weight ?",
                'category_id'     => '4',
                'status'     => 'yes',
            ]
        );

        \App\Models\Suggestion::create(
            [
                'name'      => "What is the difference between investing and trading?",
                'category_id'     => '5',
                'status'     => 'yes',
            ]
        );

    }
}
