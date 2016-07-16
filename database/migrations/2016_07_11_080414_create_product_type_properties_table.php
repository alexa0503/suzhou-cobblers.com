<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTypePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_type_properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('locale',100);
            $table->text('desc');
            $table->integer('product_type_id')->unsigned()->index();
            $table->foreign('product_type_id')->references('id')->on('product_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_type_properties');
    }
}
