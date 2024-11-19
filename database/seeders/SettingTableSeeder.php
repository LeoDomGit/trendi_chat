<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create(
            [
                'writer_limit'      => '10',
                'chat_limit'     => '15',
                'image_limit'     => '10',
                'add_is_enabled'     => 'yes',
                'support_email'     => 'info@quickl.ai',
                'privacy_policy'     => 'https://quickl.ai/privacy-policy.html',
                'terms_and_conditions'     => 'https://quickl.ai/terms-and-conditions.html',
                'faq'     => 'https://quickl.ai/faq.html',
                'app_version'     => '5.0',
                'app_homepage_theme'     => 'theme_2',
                'model_type'     => 'gpt-4',
            ]
        );
    }
}
