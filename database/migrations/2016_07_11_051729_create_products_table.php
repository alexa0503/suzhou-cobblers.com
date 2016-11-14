<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('title',255);
            //$table->text('description');
            //$table->text('thumb',255);
            $table->integer('stock');
            $table->boolean('is_active');
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('product_types');
            $table->integer('size_type_id')->unsigned()->index()->nullable();
            $table->foreign('size_type_id')->references('id')->on('product_size_types');
            $table->integer('sort_id')->default(0);
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
        Schema::drop('products');
    }
}
