<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{

    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->integer('ordering')->nullable();
            $table->string('section_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.te
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('slides');
    }
}
