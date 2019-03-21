<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('client')->nullable();
            $table->string('key',16)->nullable();
            $table->boolean('hidden')->default(0);
            $table->boolean('archived')->default(0);
            $table->integer('author_id')->unsigned()->index()->nullable();
            $table->integer('presenter_id')->unsigned()->index()->nullable();
            $table->dateTime('presentation_date')->nullable();

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
        Schema::drop('presentations');
    }
}
