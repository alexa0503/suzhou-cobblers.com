<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->text('value');
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('deliver_types');
            $table->integer('city_id')->nullable()->unsigned()->index();
            $table->foreign('city_id')->references('id')->on('world_cities');
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
        Schema::drop('deliver_fees');
    }
}
