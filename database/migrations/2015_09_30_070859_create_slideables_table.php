<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slideables', function (Blueprint $table) {
            $table->integer('slide_id')->unsigned()->nullable();
            $table->integer('slideable_id')->unsigned()->nullable();
            $table->string('slideable_type')->nullable();
            $table->integer('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slideables');
    }
}
