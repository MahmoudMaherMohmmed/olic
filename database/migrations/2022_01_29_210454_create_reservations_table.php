<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('technician_id')->unsigned();
            $table->bigInteger('car_id')->unsigned();
            $table->string('lat');
            $table->string('lng');
            $table->string('date');
            $table->string('from');
            $table->string('to');
            $table->string('coupon')->nullable();
            $table->string('total_price');
            $table->integer('payment_type')->default(0)->comment('0=>cash | 1=>bank transfer');
            $table->text('transaction_id')->nullable();
            $table->integer('status')->default(1)->comment('0=>unacceptable | 1=>Pending | 2=>approved');

            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('technician_id')->references('id')->on('technicians')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('car_id')->references('id')->on('client_cars')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('reservations');
    }
}
