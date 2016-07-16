<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePressPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('press_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('locale',100);
            $table->text('value');
            $table->integer('press_id')->unsigned()->index();
            $table->foreign('press_id')->references('id')->on('presses');
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
        Schema::drop('press_properties');
    }
}
