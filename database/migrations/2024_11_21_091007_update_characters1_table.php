<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCharacters1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('assistants');
        if (Schema::hasTable('charaters')) {
            Schema::table('characters', function (Blueprint $table) {
                $table->string('instructions',255)->nullable();
                $table->text('tools')->nullable();
                $table->string('model',255)->nullable();

            });
        }
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
