<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCharactersTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('characters')) {
            Schema::table('characters', function (Blueprint $table) {
                // Rename 'fullname' to 'name' if 'fullname' exists
                if (Schema::hasColumn('characters', 'fullname')) {
                    $table->renameColumn('fullname', 'name');
                }

                // Rename 'avatar' to 'photo' if 'avatar' exists
                if (Schema::hasColumn('characters', 'avatar')) {
                    $table->renameColumn('avatar', 'photo');
                }
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
        if (Schema::hasTable('characters')) {
            Schema::table('characters', function (Blueprint $table) {
                // Reverse the renames
                if (Schema::hasColumn('characters', 'name')) {
                    $table->renameColumn('name', 'fullname');
                }

                if (Schema::hasColumn('characters', 'photo')) {
                    $table->renameColumn('photo', 'avatar');
                }
            });
        }
    }
}
