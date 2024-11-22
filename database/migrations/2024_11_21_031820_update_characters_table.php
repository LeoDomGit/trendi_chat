<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('characters');
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('fullname',255);
            $table->string('seed')->nullable();
            $table->string('assistant_id');
            $table->text('assistant_intro')->nullable();
            $table->string('slug');
            $table->integer('id_lover_type')->default(0);
            $table->text('opening_greeting')->nullable();
            $table->text('avatar')->nullable();
            $table->integer('is_public')->default(0);
            $table->integer('is_active')->default(1);
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
