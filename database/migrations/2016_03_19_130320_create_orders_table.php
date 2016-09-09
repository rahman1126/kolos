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

            $table->integer('user_id');
            $table->integer('merchant_id');
            $table->dateTime('booking_time');
            $table->string('location');
            $table->string('note');
            $table->boolean('status')->default(0); // 0 unconfirmed, 1 accepted, 2 declined, 3 canceled
            
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
