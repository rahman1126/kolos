<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMerchantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_merchant', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('category_id');

            $table->string('company');
            $table->string('description')->nullable();
            $table->time('open_time');
            $table->time('close_time');
            $table->string('location');
            $table->string('lat');
            $table->string('lon');
            $table->string('cover')->nullable(); // user image
            $table->string('logo')->nullable(); // user image
            $table->float('rating')->default(0);

            $table->boolean('active')->default(1); // 0 inactive, 1 active
            $table->boolean('block')->default(0); // 0 unblock, 1 blocked
            $table->boolean('featured')->default(0);

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
        Schema::drop('user_merchant');
    }
}
