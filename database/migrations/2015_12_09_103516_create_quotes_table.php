<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author')->nullable()->nullable();
            $table->string('role')->nullable()->nullable();
            $table->string('image')->nullable()->nullable();
            $table->boolean('double')->default(0);
            $table->longText('quote')->nullable()->nullable();
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
        Schema::drop('quotes', function (Blueprint $table) {
        });
    }
}
