<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_users', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
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
        Schema::dropIfExists('guest_users');
    }
}
