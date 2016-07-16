<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_no',40);
            $table->decimal('total_goods',8,2);//商品总额
            $table->decimal('total_order',8,2);//订单总额
            $table->decimal('freight',8,2);//运费
            $table->string('payment',100);
            $table->string('locale',100)->index();
            $table->string('first_name',100);
            $table->string('last_name',100);
            //$table->string('consignee',100);
            $table->string('shipping_address',200);
            $table->string('shipping_type',200);
            $table->text('note');
            $table->string('zip_code',100);
            $table->string('phone_number',100);
            $table->string('fax',100);
            $table->string('city',100);
            $table->string('country',100);
            $table->string('province',100);
            $table->integer('status')->index();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('ip_address',100);
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
        Schema::drop('orders');
    }
}
