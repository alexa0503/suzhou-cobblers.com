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
            $table->bigInteger('order_no')->unsigned()->unique();
            $table->decimal('total_fee',8,2);//订单总额
            $table->decimal('items_fee',8,2);//物品总额
            $table->decimal('deliver_fee',8,2);//运费
            $table->integer('deliver_type');
            $table->integer('payment');
            $table->string('locale',100)->index();
            $table->string('consignee_first_name',100);
            $table->string('consignee_last_name',100);
            $table->string('consignee_zip_code',40);
            $table->string('consignee_phone_number',80);
            $table->string('deliver_address',200);
            $table->integer('deliver_country_id')->unsigned()->nullable();
            $table->integer('deliver_province_id')->unsigned()->nullable();
            $table->integer('deliver_city_id')->unsigned()->nullable();
            $table->string('buyer_message',400);
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
