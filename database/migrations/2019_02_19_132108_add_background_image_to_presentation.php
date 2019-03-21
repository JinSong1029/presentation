<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackgroundImageToPresentation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presentations', function(Blueprint $table)
        {
            $table->string('background_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presentations', function(Blueprint $table)
        {
            $table->dropColumn('background_image');
        });
    }
}
