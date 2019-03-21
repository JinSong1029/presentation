<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AmendColorFieldInSplitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('splits', function(Blueprint $table)
        {
            $table->dropColumn('color');
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
        Schema::table('splits', function (Blueprint $table) {
            $table->string('color')->nullable();
            $table->dropColumn('use_presentation_color');
        });
    }
}
