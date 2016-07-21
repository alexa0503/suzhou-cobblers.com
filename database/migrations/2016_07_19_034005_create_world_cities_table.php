<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorldCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('world_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_cn',60);
            $table->string('name_en',60);
            $table->integer('parent_id')->nullable()->unsigned()->index();
            $table->foreign('parent_id')->references('id')->on('world_cities');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('world_cities');
    }
}
