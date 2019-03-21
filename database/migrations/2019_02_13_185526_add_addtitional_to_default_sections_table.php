<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddtitionalToDefaultSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('default_sections', function(Blueprint $table)
        {
            $table->boolean('additional')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('default_sections', function(Blueprint $table)
        {
            $table->dropColumn('additional');
        });
    }
}
