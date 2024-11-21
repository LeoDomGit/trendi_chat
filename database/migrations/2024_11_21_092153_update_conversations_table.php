<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('conversations');
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('assistant_id',255)->nullable();
            $table->string('thread_id')->nullable();
            $table->string('run_id')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->text('last_message')->nullable();
            $table->boolean('sort')->default(0);
            $table->boolean('is_active')->default(1);
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
        //
    }
}
