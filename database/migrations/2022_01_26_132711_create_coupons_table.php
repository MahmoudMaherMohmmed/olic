<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('oil_id')->unsigned();
            $table->string('coupon');
            $table->string('from');
            $table->string('to');
            $table->string('discount');
            $table->integer('status')->default(1)->comment('0=>Not Avaliable | 1=>Avaliable');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('oil_id')->references('id')->on('oil')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
