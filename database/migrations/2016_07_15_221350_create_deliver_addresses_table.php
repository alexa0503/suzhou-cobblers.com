<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliver_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city',100);
            $table->string('country',100);
            $table->string('province',100);
            $table->string('zip_code',100);
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('detailed_address',200);
            $table->string('phone_number',100);
            $table->boolean('is_default');
            $table->string('locale',100)->index();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('deliver_addresses');
    }
}
