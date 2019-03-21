<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmendOverlayInImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function(Blueprint $table)
        {
            $table->dropColumn('overlay_color');
            $table->boolean('use_presentation_color')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('overlay_color')->nullable();
            $table->dropColumn('use_presentation_color');
        });
    }
}
