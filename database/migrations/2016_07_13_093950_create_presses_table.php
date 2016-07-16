<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presses', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('title',255);
            $table->string('thumb',255);
            $table->string('image',255);
            $table->integer('parent_id')->unsigned()->nullable()->index();
            $table->foreign('parent_id')->references('id')->on('presses');
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
        Schema::drop('presses');
    }
}
