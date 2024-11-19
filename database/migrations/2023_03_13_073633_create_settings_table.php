<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
          $table->id();
          $table->string('writer_limit');
          $table->string('chat_limit');
          $table->string('image_limit');
          $table->string('reffered_limit');
          $table->string('apikey_android_revenuecat');
          $table->string('apikey_ios_revenuecat');
          $table->string('openai_api_key');
          $table->string('add_is_enabled');
          $table->string('android_app_id');
          $table->string('ios_app_id');
          $table->string('android_banner_id');
          $table->string('ios_banner_id');
          $table->string('android_interstitial_id');
          $table->string('ios_interstitial_id');
          $table->string('support_email');
          $table->string('privacy_policy');
          $table->string('terms_and_conditions');
          $table->string('faq');
          $table->string('app_version');
          $table->string('ads_writer_limit');
          $table->string('ads_chat_limit');
          $table->string('ads_image_limit');
          $table->string('android_reward_ads_id');
          $table->string('ios_reward_ads_id');
          $table->string('app_homepage_theme');
          $table->string('model_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
