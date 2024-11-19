<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('photo');
            $table->string('status');
            $table->string('password');
            $table->string('referral_code')->nullable();
            $table->string('join_by_referral_code')->nullable();
            $table->string('writer_limit');
            $table->string('chat_limit');
            $table->string('image_limit');
            $table->string('chat_request');
            $table->string('chat_word_count');
            $table->string('proms_request');
            $table->string('proms_word_count');
            $table->string('image_request');
           
            $table->longText('fcmtoken');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_users');
    }
}
