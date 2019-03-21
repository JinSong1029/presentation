<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTombstonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tombstones', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('label')->nullable();
            $table->string('image')->nullable();
            $table->longText('desc')->nullable();
            $table->boolean('double')->default(0);
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
        Schema::drop('tombstones');
    }
}
